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
        Schema::create('dokumen_meetings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_surat_tugas');
            $table->bigInteger('inserted_by');
            $table->string('jenis_dokumen');
            $table->string('path_dokumen');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_meetings');
    }
};
