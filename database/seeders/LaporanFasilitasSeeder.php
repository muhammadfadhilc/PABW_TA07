<?php

namespace Database\Seeders;

use App\Models\AdminPetugas;
use App\Models\LaporanFasilitas;
use App\Models\Warga;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class LaporanFasilitasSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $wargaIds = Warga::pluck('id')->all();
        if (empty($wargaIds)) {
            throw new \RuntimeException('Jalankan WargaSeeder lebih dulu.');
        }

        $kontraktorId = AdminPetugas::where('username', 'kontraktor')->value('id');
        $fasilitas = ['Jalan Raya', 'Penerangan Jalan', 'Saluran Air', 'Lainnya'];
        $status = ['Menunggu', 'Diproses', 'Selesai'];

        // Pemetaan berdasarkan username, bukan urutan ID, agar sesuai dengan akun lama.
        $awal = [
            ['andika', 'Jalan Raya', 'RT 05 RW 02, Dekat Masjid Al-Ikhlas', 'Jalan berlubang cukup dalam sekitar 15 cm, membahayakan pengendara motor.', 'Diproses'],
            ['rania', 'Penerangan Jalan', 'Gang Mawar 3, RT 01', 'Lampu PJU mati sejak 3 hari yang lalu, jalanan gelap gulita di malam hari.', 'Diproses'],
            ['fadhil', 'Saluran Air', 'Dusun Citeureup Selatan', 'Saluran air tersumbat sampah plastik menyebabkan genangan saat hujan deras.', 'Selesai'],
        ];

        foreach ($awal as [$username, $tipe, $lokasi, $deskripsi, $statusAwal]) {
            $wargaId = Warga::where('username', $username)->value('id');
            LaporanFasilitas::firstOrCreate(
                ['id_warga' => $wargaId, 'lokasi' => $lokasi, 'tipe_fasilitas' => $tipe],
                [
                    'deskripsi' => $deskripsi,
                    'status' => $statusAwal,
                    'tanggal_lapor' => '2026-06-08 17:17:58',
                    'id_kontraktor' => $kontraktorId,
                ]
            );
        }

        // ID simulasi dalam lokasi membuat seeder aman dijalankan kembali tanpa menggandakan 20 laporan.
        for ($i = 1; $i <= 20; $i++) {
            $lokasi = sprintf('[SIMULASI-%02d] %s, Citeureup, Kabupaten Bandung', $i, $faker->streetAddress);
            // Pencarian penanda memastikan baris lama dari seed ini tidak digandakan.
            $penanda = sprintf('[SIMULASI-%02d]', $i);
            if (LaporanFasilitas::where('lokasi', 'like', $penanda . '%')->exists()) {
                continue;
            }
            LaporanFasilitas::create([
                'id_warga' => $faker->randomElement($wargaIds),
                'tipe_fasilitas' => $faker->randomElement($fasilitas),
                'lokasi' => $lokasi,
                'deskripsi' => $faker->sentence($faker->numberBetween(8, 16)),
                'status' => $status[($i - 1) % 3],
                'tanggal_lapor' => $faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d H:i:s'),
                'id_kontraktor' => $i % 3 === 0 ? null : $kontraktorId,
            ]);
        }
    }
}
