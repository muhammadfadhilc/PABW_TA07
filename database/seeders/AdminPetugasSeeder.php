<?php

namespace Database\Seeders;

use App\Models\AdminPetugas;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminPetugasSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        foreach ([
            ['Rousyan Fikr (Admin)', 'admin', 'admin123', 'admin'],
            ['Kepala Desa Citeureup (Super)', 'super', 'super123', 'superadmin'],
            ['PT Semen Jaya (Kontraktor)', 'kontraktor', 'vendor123', 'kontraktor'],
        ] as [$nama, $username, $password, $role]) {
            AdminPetugas::firstOrCreate(
                ['username' => $username],
                ['nama' => $nama, 'password' => Hash::make($password), 'role' => $role]
            );
        }

        for ($i = 1; $i <= 4; $i++) {
            AdminPetugas::firstOrCreate(
                ['username' => 'petugas' . $i],
                [
                    'nama' => $faker->name,
                    'password' => Hash::make('petugas123'),
                    'role' => $faker->randomElement(['admin', 'kontraktor']),
                ]
            );
        }
    }
}
