<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lhas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('inserted_by');
            $table->json('id_kertas_kerja');
            $table->enum('action', [
                'draft',
                'diajukan',
                'revisi',
                'disetujui',
                'ditindaklanjuti',
                'tindaklanjut_ok',
                'selesai'
            ]);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lhas');
    }
};
