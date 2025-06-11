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
        Schema::table('mensaje_contactos', function (Blueprint $table) {
             $table->renameColumn('nombre', 'asunto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mensaje_contactos', function (Blueprint $table) {
             $table->renameColumn('asunto', 'nombre');
        });
    }
};
