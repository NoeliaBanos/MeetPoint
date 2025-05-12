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

Route::get('/', [EspacioController::class, 'index'])->name('espacios.index');
Route::resource('espacios', EspacioController::class)->only(['index', 'show']);

/* ---------- RESEÑAS ---------------------------------- */
//   • Cualquiera puede ver index y show
Route::resource('resenas', ResenaController::class)->only(['index', 'show']);
//   • Solo usuarios autenticados pueden CREAR / EDITAR / BORRAR
Route::middleware('auth')->group(function () {
    Route::resource('resenas', ResenaController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy']);
});

/* ---------- RESERVAS --------------------------------- */
Route::resource('reservas', ReservaController::class)->only(['index', 'show']);
Route::middleware('auth')->group(function () {
    Route::resource('reservas', ReservaController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy']);
});

/* ---------- Perfil de usuario ----------------------- */
Route::middleware('auth')->group(function () {
    // Dashboard (usa el mismo método show de ProfileController)
    Route::get('/dashboard', [ProfileController::class, 'show'])
        ->name('dashboard');

    // Página "Mi perfil"
    Route::get('/profile', [ProfileController::class, 'show'])
        ->name('profile.show');

    // Formulario de edición de perfil
    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    // Procesar actualización de perfil
    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
         // Mostrar formulario de cambio de contraseña
    Route::get(
        '/profile/password',
        [ProfileController::class, 'editPassword']
    )
    ->name('password.edit');

    // Procesar cambio de contraseña
    Route::put(
        '/profile/password',
        [ProfileController::class, 'updatePassword']
    )
    ->name('password.update');
});


/* ---------- Páginas públicas de contacto y legal ----- */
Route::get('/contacto', [MensajeContactoController::class, 'create'])
    ->name('contacto.create');
Route::post('/contacto', [MensajeContactoController::class, 'store'])
    ->name('contacto.store');

Route::view('/legal', 'legal')->name('legal');

require __DIR__ . '/auth.php';
