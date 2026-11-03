<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up():void { Schema::create('laporan_jalan',function(Blueprint $table){
  $table->id(); $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
  $table->foreignId('ruas_jalan_id')->nullable()->constrained('ruas_jalan')->nullOnDelete();
  $table->string('jenis_kerusakan',30); $table->string('lokasi',255);
  $table->text('deskripsi'); $table->decimal('latitude',10,7)->nullable();
  $table->decimal('longitude',10,7)->nullable(); $table->string('foto_path')->nullable();
  $table->string('status',32)->default('Menunggu Verifikasi');
  $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
  $table->timestamps();
 }); }
 public function down():void { Schema::dropIfExists('laporan_jalan'); }
};