<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nomor_lomba', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelompok_umur_id')->constrained('kelompok_umur')->cascadeOnDelete();
            $table->string('nama_nomor'); // Contoh: "100m Gaya Bebas Putra"
            $table->unsignedSmallInteger('jarak'); // dalam meter
            $table->enum('gaya', [
                'bebas',
                'dada',
                'punggung',
                'kupu',
                'ganti_perorangan',
                'ganti_estafet',
            ]);
            $table->enum('jenis_kelamin', ['putra', 'putri', 'campuran']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nomor_lomba');
    }
};
