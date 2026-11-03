<?php
namespace Database\Seeders;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder {
 public function run():void {
  $faker=Faker::create('id_ID');
  for($i=1;$i<=5;$i++){
   $email='warga'.$i.'@roadwatch.test';
   User::firstOrCreate(['email'=>$email],[
    'name'=>$faker->name, 'password'=>Hash::make('Latihan123!'), 'role'=>'warga'
   ]);
  }
  foreach([
   ['Administrator Desa','admin@roadwatch.test','admin'],
   ['Petugas Teknis Desa','petugas@roadwatch.test','petugas'],
   ['Kepala Desa','kepala@roadwatch.test','kepala_desa'],
  ] as [$name,$email,$role]){
   User::firstOrCreate(['email'=>$email],[
    'name'=>$name,'password'=>Hash::make('Latihan123!'),'role'=>$role
   ]);
  }
 }
}