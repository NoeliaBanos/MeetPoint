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
        // 'nombre'      => 'Carlos',
        // 'email'       => 'carlos@example.com',
        // 'telefono'    => '123456789',
        // 'mensaje'     => 'Quisiera saber si hay disponibilidad para este viernes.',
        // 'created_at'  => now(),
        // 'updated_at'  => now(),
        Schema::create('mensaje_contactos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null');
            $table->string('nombre');
            $table->string('email');
            $table->string('telefono');
            $table->text('mensaje');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensaje_contactos');
    }
};
