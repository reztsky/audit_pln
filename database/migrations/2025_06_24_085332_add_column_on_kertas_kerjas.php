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
        Schema::table('kertas_kerjas', function (Blueprint $table) {
            $table->after('id_pka',function($t){
                $t->bigInteger('id_lha')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kertas_kerjas', function (Blueprint $table) {
            $table->dropColumn('id_lha');
        });
    }
};
