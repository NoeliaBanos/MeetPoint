<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('reservas', function (Blueprint $table) {
        $table->decimal('importe', 10, 2)->nullable()->after('fecha_hora');
        $table->enum('pago_estado', ['pendiente','pagado'])
              ->default('pendiente')
              ->after('importe');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            //
        });
    }
};
