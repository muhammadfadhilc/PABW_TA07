<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laporan_v2', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_warga')->constrained('warga_v2')->cascadeOnDelete();
            $table->string('tipe_fasilitas', 50);
            $table->string('lokasi', 150);
            $table->text('deskripsi')->nullable();
            $table->string('status', 20)->default('Menunggu');
            $table->dateTime('tanggal_lapor');
            $table->foreignId('id_kontraktor')->nullable()->constrained('admins_v2')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_v2');
    }
};
