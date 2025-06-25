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
        Schema::create('tindak_lanjut_lhas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_lha'); // hubungan dengan LHA
            $table->bigInteger('inserted_by');
            $table->text('tindak_lanjut')->nullable(); // penjelasan
            $table->string('eviden_path')->nullable(); // path file eviden
            $table->enum('status', ['draft', 'diajukan', 'revisi', 'disetujui'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tindak_lanjut_lhas');
    }
};
