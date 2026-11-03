<?php
namespace App\Http\Controllers;
use App\Models\LaporanJalan;
use App\Models\RuasJalan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
class RoadWatchController extends Controller {
 private function scopeLaporan(){
  $u=Auth::user(); $q=LaporanJalan::query();
  if($u->role==='warga') $q->where('user_id',$u->id);
  if($u->role==='petugas') $q->where('assigned_to',$u->id);
  return $q;
 }
 private function canView(LaporanJalan $laporan):void {
  $u=Auth::user();
  abort_unless(in_array($u->role,['admin','kepala_desa']) ||
   ($u->role==='warga' && $laporan->user_id===$u->id) ||
   ($u->role==='petugas' && $laporan->assigned_to===$u->id),403);
 }
 public function dashboard(){
  $rows=$this->scopeLaporan()->latest()->get();
  return view('roadwatch.dashboard',['rows'=>$rows, 'total'=>$rows->count(),
   'menunggu'=>$rows->where('status','Menunggu Verifikasi')->count(),
   'selesai'=>$rows->where('status','Selesai')->count()]);
 }
 public function profile(){return view('roadwatch.profile');}
 public function index(){return view('roadwatch.index', ['rows'=>$this->scopeLaporan()->latest()->paginate(10)]);}
 public function create(){
  abort_unless(Auth::user()->role==='warga',403);
  return view('roadwatch.create',['ruas'=>RuasJalan::orderBy('nama')->get()]);
 }
 public function store(Request $request){
  abort_unless(Auth::user()->role==='warga',403);
  $d=$request->validate([
   'jenis_kerusakan'=>['required',Rule::in(['Lubang','Retak','Ambles'])],
   'lokasi'=>['required','string','max:255'], 'deskripsi'=>['required','string','max:2000'],
   'ruas_jalan_id'=>['nullable','exists:ruas_jalan,id'],
   'latitude'=>['nullable','numeric','between:-90,90'],
   'longitude'=>['nullable','numeric','between:-180,180'],
   'foto'=>['nullable','image','mimes:jpg,jpeg,png','max:2048'],
  ]);
  unset($d['foto']);$d['user_id']=Auth::id();$d['status']='Menunggu Verifikasi';
  if($request->hasFile('foto')) $d['foto_path']=$request->file('foto')->store('roadwatch','local');
  LaporanJalan::create($d);
  return redirect()->route('laporan.index')->with('success','Laporan kerusakan jalan terkirim.');
 }
 public function show(LaporanJalan $laporan){
  $this->canView($laporan);
  return view('roadwatch.show',['laporan'=>$laporan,'petugas'=>User::where('role','petugas')->orderBy('name')->get()]);
 }
 public function photo(LaporanJalan $laporan){
  $this->canView($laporan);
  abort_unless($laporan->foto_path, 404);
  // Foto Modul 7 tersimpan di public; foto lama dari Modul 6 tetap dapat dibuka.
  if (Storage::disk('public')->exists($laporan->foto_path)) {
   return Storage::disk('public')->response($laporan->foto_path);
  }
  abort_unless(Storage::disk('local')->exists($laporan->foto_path), 404);
  return Storage::disk('local')->response($laporan->foto_path);
 }
 public function status(Request $request,LaporanJalan $laporan){
  $u=Auth::user();$this->canView($laporan);
  abort_unless(in_array($u->role,['admin','petugas']),403);
  $d=$request->validate(['status'=>['required','string'],'assigned_to'=>['nullable','exists:users,id']]);
  if($u->role==='admin'){
   $allowed=['Menunggu Verifikasi'=>['Terverifikasi','Ditolak'],'Terverifikasi'=>['Ditugaskan','Diteruskan']];
   abort_unless(in_array($d['status'],$allowed[$laporan->status]??[],true),422);
   if($d['status']==='Ditugaskan'){
    $request->validate(['assigned_to'=>['required','exists:users,id']]);
    $staff=User::findOrFail($d['assigned_to']);abort_unless($staff->role==='petugas',422);
    $laporan->assigned_to=$staff->id;
   }
  } else {
   abort_unless($laporan->assigned_to===$u->id,403);
   $allowed=['Ditugaskan'=>'Diproses','Diproses'=>'Selesai'];
   abort_unless(($allowed[$laporan->status]??'')===$d['status'],422);
  }
  $laporan->status=$d['status'];$laporan->save();
  return redirect()->route('laporan.show',$laporan)->with('success','Status diperbarui.');
 }
}