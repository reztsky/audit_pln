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
        Schema::create('lha_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lha_id');           // FK ke tabel lhas
            $table->unsignedBigInteger('inserted_by');          // siapa yg mengubah
            $table->enum('action', [
                'draft',
                'diajukan',
                'revisi',
                'disetujui',
                'ditindaklanjuti',
                'revisi_tindaklanjut',
                'tindaklanjut_ok',
                'selesai'
            ]);
            $table->text('catatan')->nullable();            // alasan revisi, catatan tambahan, dll
            $table->foreign('lha_id')->references('id')->on('lhas')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lha_logs');
    }
};
