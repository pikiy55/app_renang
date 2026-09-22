<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users'); // admin pelaku
            $table->string('action'); // edit, delete, import, export
            $table->string('model_type'); // class model yang diubah, misal App\Models\Pendaftaran
            $table->unsignedBigInteger('model_id'); // ID record yang diubah
            $table->json('before')->nullable(); // data sebelum perubahan
            $table->json('after')->nullable();  // data sesudah perubahan
            $table->timestamps();

            $table->index(['model_type', 'model_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
