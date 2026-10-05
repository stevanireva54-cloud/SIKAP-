<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            // Identitas utama
            $table->string('nip')->unique();
            $table->string('nik_internal')->nullable();
            $table->string('nama_lengkap');

            // Data pekerjaan
            $table->string('jabatan')->nullable();
            $table->string('rig')->nullable();
            $table->string('crew')->nullable();
            $table->string('schedule')->nullable();
            $table->date('tanggal_bergabung')->nullable();

            // Status
            $table->enum('status', ['Aktif', 'Nonaktif'])
                ->default('Aktif');

            // Foto profil
            $table->string('foto_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};