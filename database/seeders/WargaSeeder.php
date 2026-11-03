<?php

namespace Database\Seeders;

use App\Models\Warga;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class WargaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        // firstOrCreate mempertahankan akun yang sudah terdaftar, termasuk password-nya.
        foreach ([
            ['Andika Ramadhan', 'andika'],
            ['Rania Renata', 'rania'],
            ['Muhammad Fadhil Cholilullah', 'fadhil'],
        ] as [$nama, $username]) {
            Warga::firstOrCreate(
                ['username' => $username],
                ['nama' => $nama, 'password' => Hash::make('warga123')]
            );
        }

        for ($i = 1; $i <= 12; $i++) {
            $username = 'warga' . str_pad((string) $i, 3, '0', STR_PAD_LEFT);
            Warga::firstOrCreate(
                ['username' => $username],
                ['nama' => $faker->name, 'password' => Hash::make('warga123')]
            );
        }
    }
}
