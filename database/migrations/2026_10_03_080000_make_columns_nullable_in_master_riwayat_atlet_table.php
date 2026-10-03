<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_riwayat_atlet', function (Blueprint $table) {
            $table->unsignedSmallInteger('jarak')->nullable()->change();
            $table->string('gaya', 50)->nullable()->change();
            $table->string('limit_waktu')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('master_riwayat_atlet', function (Blueprint $table) {
            $table->unsignedSmallInteger('jarak')->nullable(false)->change();
            $table->enum('gaya', [
                'bebas',
                'dada',
                'punggung',
                'kupu',
                'ganti_perorangan',
                'ganti_estafet',
            ])->nullable(false)->change();
            $table->string('limit_waktu')->nullable(false)->change();
        });
    }
};
