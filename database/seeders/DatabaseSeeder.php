<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder {
 public function run():void {
  $this->call([
   WargaSeeder::class, AdminPetugasSeeder::class, LaporanFasilitasSeeder::class,
   UserSeeder::class,
  ]);
 }
}