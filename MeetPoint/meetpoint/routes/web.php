<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    EspacioController,
    ReservaController,
    ResenaController,
    MensajeContactoController,
    PaymentController
};

/* ---------- Espacios, HOME, etc.  -------------------- */

// Público: listar y ver detalle
Route::get('/', [EspacioController::class, 'index'])
     ->name('espacios.index');
Route::resource('espacios', EspacioController::class)
     ->only(['index', 'show']);

// Protegido: crear / almacenar / editar / actualizar / borrar / verificar espacios
Route::middleware('auth')->group(function () {
    // CRUD básico
    Route::resource('espacios', EspacioController::class)
         ->only(['create', 'store', 'edit', 'update', 'destroy']);

    // Marcar como apta
    Route::post('espacios/{espacio}/apta', [
        EspacioController::class,
        'markApta'
    ])->name('espacios.apta');

    // Marcar como no apta
    Route::post('espacios/{espacio}/no-apta', [
        EspacioController::class,
        'markNoApta'
    ])->name('espacios.no_apta');
});

/* ---------- RESEÑAS ---------------------------------- */

// Público: ver todas y detalle
Route::resource('resenas', ResenaController::class)
     ->only(['index', 'show']);

// Protegido: crear / almacenar / editar / actualizar / borrar
Route::middleware('auth')->group(function () {
    Route::resource('resenas', ResenaController::class)
         ->only(['create', 'store', 'edit', 'update', 'destroy']);
});

/* ---------- RESERVAS --------------------------------- */

// Público: ver todas y detalle
Route::resource('reservas', ReservaController::class)
     ->only(['index', 'show']);

// Protegido: crear / almacenar / editar / actualizar / borrar
Route::middleware('auth')->group(function () {
    Route::resource('reservas', ReservaController::class)
         ->only(['create', 'store', 'edit', 'update', 'destroy']);
});

/* ---------- Perfil de usuario ----------------------- */

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [ProfileController::class, 'show'])
         ->name('dashboard');

    // Mi perfil
    Route::get('/profile', [ProfileController::class, 'show'])
         ->name('profile.show');

    // Editar perfil
    Route::get('/profile/edit', [ProfileController::class, 'edit'])
         ->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])
         ->name('profile.update');

    // Cambiar contraseña
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])
         ->name('password.edit');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
         ->name('password.update');
});

/* ---------- Contacto y Mensajes --------------------- */

// Público: FAQ + formulario de contacto
Route::get('/contacto', [MensajeContactoController::class, 'create'])
     ->name('contacto.create');
Route::post('/contacto', [MensajeContactoController::class, 'store'])
     ->name('contacto.store');

// Protegido (solo admin): eliminar mensaje
Route::middleware('auth')->delete(
    '/contacto/{mensaje}',
    [MensajeContactoController::class, 'destroy']
)->name('contacto.destroy');

/* ---------- Legal ----------------------------------- */

Route::view('/legal', 'legal')->name('legal');

/* ---------- Auth ------------------------------------ */

require __DIR__ . '/auth.php';
