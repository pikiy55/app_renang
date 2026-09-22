<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // perkumpulan pendaftar
            $table->foreignId('kelompok_umur_id')->constrained('kelompok_umur');
            $table->foreignId('nomor_lomba_id')->constrained('nomor_lomba');
            $table->string('nama_atlet');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['putra', 'putri']);
            $table->string('limit_waktu')->nullable(); // format: MM:SS.ss
            $table->enum('status_waktu', ['normal', 'NT'])->default('NT');
            $table->boolean('is_locked')->default(false);
            $table->timestamps();

            // Satu atlet hanya boleh daftar satu kali per nomor lomba per event
            $table->unique(['event_id', 'nomor_lomba_id', 'nama_atlet']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
