<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_riwayat_atlet', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // perkumpulan pemilik data
            $table->string('nama_atlet');
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['putra', 'putri']);
            $table->unsignedSmallInteger('jarak'); // dalam meter
            $table->enum('gaya', [
                'bebas',
                'dada',
                'punggung',
                'kupu',
                'ganti_perorangan',
                'ganti_estafet',
            ]);
            $table->string('limit_waktu'); // format: MM:SS.ss
            $table->timestamps();

            // Index untuk performa auto-complete & auto-match
            $table->index(['nama_atlet', 'user_id']);
            $table->index(['nama_atlet', 'jarak', 'gaya', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_riwayat_atlet');
    }
};
