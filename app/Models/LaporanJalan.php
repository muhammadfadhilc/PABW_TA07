<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class LaporanJalan extends Model {
 protected $table='laporan_jalan';
 protected $fillable=['user_id','ruas_jalan_id','jenis_kerusakan','lokasi','deskripsi','latitude','longitude','foto_path','status','assigned_to'];
 public function pelapor(){ return $this->belongsTo(User::class,'user_id'); }
 public function petugas(){ return $this->belongsTo(User::class,'assigned_to'); }
 public function ruas(){ return $this->belongsTo(RuasJalan::class,'ruas_jalan_id'); }
}