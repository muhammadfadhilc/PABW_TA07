<?php

namespace Tests\Feature;

use App\Models\LaporanJalan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/** Jalankan jika project dilengkapi infrastruktur PHPUnit Laravel dan ekstensi GD tersedia. */
class LaporanJalanModul7Test extends TestCase
{
    use RefreshDatabase;

    private function makeUser(string $role = 'warga'): User
    {
        return User::create([
            'name' => ucfirst($role),
            'email' => uniqid($role, true) . '@example.test',
            'password' => 'Password123!',
            'role' => $role,
        ]);
    }

    private function validForm(UploadedFile $file): array
    {
        return [
            'jenis_kerusakan' => 'Lubang',
            'lokasi' => 'Jalan Citeureup',
            'deskripsi' => 'Lubang cukup besar dan membahayakan pengendara.',
            'foto' => $file,
        ];
    }

    public function test_guest_diarahkan_ke_login(): void
    {
        $this->get('/laporan')->assertRedirect('/login');
    }

    public function test_warga_dapat_membuat_mengubah_dan_menghapus_laporan_beserta_foto(): void
    {
        Storage::fake('public');
        $warga = $this->makeUser();
        $this->actingAs($warga)->post(route('laporan.store'), $this->validForm(
            UploadedFile::fake()->image('bukti.jpg')
        ))->assertRedirect(route('laporan.index'));

        $laporan = LaporanJalan::firstOrFail();
        $oldPath = $laporan->foto_path;
        Storage::disk('public')->assertExists($oldPath);

        $this->actingAs($warga)->put(route('laporan.update', $laporan), [
            'jenis_kerusakan' => 'Retak',
            'lokasi' => 'Jalan Citeureup',
            'deskripsi' => 'Retakan memanjang.',
            'foto' => UploadedFile::fake()->image('baru.png'),
        ])->assertRedirect(route('laporan.show', $laporan));

        $laporan->refresh();
        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($laporan->foto_path);
        $newPath = $laporan->foto_path;

        $this->actingAs($warga)->delete(route('laporan.destroy', $laporan))
            ->assertRedirect(route('laporan.index'));
        $this->assertDatabaseMissing('laporan_jalan', ['id' => $laporan->id]);
        Storage::disk('public')->assertMissing($newPath);
    }

    public function test_warga_lain_dilarang_mengedit_laporan(): void
    {
        $pemilik = $this->makeUser();
        $asing = $this->makeUser();
        $laporan = LaporanJalan::create([
            'user_id' => $pemilik->id,
            'jenis_kerusakan' => 'Lubang',
            'lokasi' => 'Citeureup',
            'deskripsi' => 'Lubang jalan',
        ]);
        $this->actingAs($asing)->get(route('laporan.edit', $laporan))->assertForbidden();
        $this->actingAs($asing)->delete(route('laporan.destroy', $laporan))->assertForbidden();
    }

    public function test_foto_pdf_ditolak_oleh_validasi(): void
    {
        Storage::fake('public');
        $user = $this->makeUser();
        $this->actingAs($user)->post(route('laporan.store'), $this->validForm(
            UploadedFile::fake()->create('dokumen.pdf', 300, 'application/pdf')
        ))->assertSessionHasErrors('foto');
        $this->assertDatabaseCount('laporan_jalan', 0);
    }
}
