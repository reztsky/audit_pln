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
        Schema::create('kertas_kerjas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('inserted_by');
            $table->bigInteger('id_pka');
            $table->string('kontrol');
            $table->date('tanggal');
            $table->enum('kategori_temuan', [
                'Major',
                'Minor',
                'Ofi',
                'Sesuai'
            ]);
            $table->longText('temuan')->nullable();
            $table->longText('ofi')->nullable();
            $table->longText('keterangan_tambahan')->nullable();
            $table->string('dokumen_dukung')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kertas_kerjas');
    }
};
