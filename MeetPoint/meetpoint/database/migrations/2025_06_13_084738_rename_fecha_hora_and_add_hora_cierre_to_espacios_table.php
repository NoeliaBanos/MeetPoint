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
        Schema::table('espacios', function (Blueprint $table) {
            // 1) Quitamos la columna DATETIME que sobra
            if (Schema::hasColumn('espacios', 'fecha_hora')) {
                $table->dropColumn('fecha_hora');
            }

            // 2) Creamos las columnas TIME
            $table->time('hora_apertura')->after('capacidad');
            $table->time('hora_cierre')->after('hora_apertura');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('espacios', function (Blueprint $table) {
             // para revertir, volvemos a datetime y borramos los TIME
            $table->dateTime('fecha_hora')->after('capacidad');
            $table->dropColumn(['hora_apertura', 'hora_cierre']);
        });
    }
};
