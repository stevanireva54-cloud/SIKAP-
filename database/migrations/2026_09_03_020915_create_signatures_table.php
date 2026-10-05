<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('signatures', function (Blueprint $table) {
            $table->id();

            // Nama pemilik tanda tangan
            $table->string('name');

            // Jabatan, misalnya Rig Supt / Area Manager
            $table->string('position')->nullable();

            // Lokasi file PNG/JPG tanda tangan
            $table->string('file_path');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('signatures');
    }
};