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
        Schema::create('pkas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('inserted_by');
            $table->bigInteger('id_surat_tugas');
            $table->text('landasan_audit');
            $table->text('tujuan_audit');
            $table->text('sasaran_audit');
            $table->text('lingkup_audit');
            $table->text('gambaran_audit');
            $table->text('data_awal');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkas');
    }
};
