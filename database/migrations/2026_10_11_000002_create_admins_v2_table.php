<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admins_v2', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('username', 50)->unique();
            $table->string('password');
            $table->string('role', 20)->default('admin');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins_v2');
    }
};
