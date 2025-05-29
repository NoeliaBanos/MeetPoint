<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\{
     EspacioController,
     ReservaController,
     ResenaController,
     MensajeContactoController,
     HomeController,
     ProfileController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

/* ---------- Espacios: listado y detalle (público) ---------- */

/* Portada ─ / */

Route::get('/', [HomeController::class, 'index'])
     ->name('index');

/* Listado de espacios ─ /espacios */
Route::get('/espacios', [EspacioController::class, 'index'])
     ->name('espacios.index');

Route::get('espacios/{espacio}', [EspacioController::class, 'show'])->name('espacios.show');

Route::middleware('auth')->group(function () {
     Route::get('espacios/create', [EspacioController::class, 'create'])->name('espacios.create');
     Route::post('espacios', [EspacioController::class, 'store'])->name('espacios.store');
     Route::get('espacios/{espacio}/edit', [EspacioController::class, 'edit'])->name('espacios.edit');
     Route::put('espacios/{espacio}', [EspacioController::class, 'update'])->name('espacios.update');
     Route::delete('espacios/{espacio}', [EspacioController::class, 'destroy'])->name('espacios.destroy');
     Route::post('espacios/{espacio}/apta', [EspacioController::class, 'markApta'])->name('espacios.apta');
     Route::post('espacios/{espacio}/no-apta', [EspacioController::class, 'markNoApta'])->name('espacios.no_apta');
});


/* ----- Crear / almacenar Espacios (solo ADMIN en controlador) ----- */
Route::middleware('auth')->group(function () {
     Route::get('espacios/create', [EspacioController::class, 'create'])
          ->name('espacios.create');
     Route::post('espacios', [EspacioController::class, 'store'])
          ->name('espacios.store');

     /* ----- Editar / actualizar / borrar / verificar Espacios ----- */
     Route::get('espacios/{espacio}/edit', [EspacioController::class, 'edit'])
          ->name('espacios.edit');
     Route::put('espacios/{espacio}', [EspacioController::class, 'update'])
          ->name('espacios.update');
     Route::delete('espacios/{espacio}', [EspacioController::class, 'destroy'])
          ->name('espacios.destroy');

     Route::post('espacios/{espacio}/apta', [EspacioController::class, 'markApta'])
          ->name('espacios.apta');
     Route::post('espacios/{espacio}/no-apta', [EspacioController::class, 'markNoApta'])
          ->name('espacios.no_apta');
});

/* ---------- Reseñas ---------- */
// público: ver listado y detalle
Route::get('resenas', [ResenaController::class, 'index'])
     ->name('resenas.index');
Route::get('resenas/{resena}', [ResenaController::class, 'show'])
     ->name('resenas.show');

// autenticados: crear / almacenar / editar / actualizar / borrar
Route::middleware('auth')->group(function () {
     Route::get('resenas/create', [ResenaController::class, 'create'])
          ->name('resenas.create');
     Route::post('resenas', [ResenaController::class, 'store'])
          ->name('resenas.store');
     Route::get('resenas/{resena}/edit', [ResenaController::class, 'edit'])
          ->name('resenas.edit');
     Route::put('resenas/{resena}', [ResenaController::class, 'update'])
          ->name('resenas.update');
     Route::delete('resenas/{resena}', [ResenaController::class, 'destroy'])
          ->name('resenas.destroy');
});

/* ---------- Reservas ---------- */
// público: ver listado y detalle
Route::get('reservas', [ReservaController::class, 'index'])
     ->name('reservas.index');
Route::get('reservas/{reserva}', [ReservaController::class, 'show'])
     ->name('reservas.show');

// autenticados: crear / almacenar / editar / actualizar / borrar
Route::middleware('auth')->group(function () {
     Route::get('reservas/create', [ReservaController::class, 'create'])
          ->name('reservas.create');
     Route::post('reservas', [ReservaController::class, 'store'])
          ->name('reservas.store');
     Route::get('reservas/{reserva}/edit', [ReservaController::class, 'edit'])
          ->name('reservas.edit');
     Route::put('reservas/{reserva}', [ReservaController::class, 'update'])
          ->name('reservas.update');
     Route::delete('reservas/{reserva}', [ReservaController::class, 'destroy'])
          ->name('reservas.destroy');
});

/* ---------- Verificación de correo ---------- */
Route::get('/email/verify', function () {
     return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
     $request->fulfill();
     return redirect()->route('profile.show')
          ->with('status', 'Correo verificado correctamente.');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
     $request->user()->sendEmailVerificationNotification();
     return back()->with('status', 'Se ha reenviado el correo de verificación.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

/* ---------- Perfil de usuario ---------- */
Route::middleware('auth')->group(function () {
     Route::get('/dashboard', [ProfileController::class, 'show'])
          ->name('dashboard');
     Route::get('/profile', [ProfileController::class, 'show'])
          ->name('profile.show');
     Route::get('/profile/edit', [ProfileController::class, 'edit'])
          ->name('profile.edit');
     Route::put('/profile', [ProfileController::class, 'update'])
          ->name('profile.update');
     Route::get('/profile/password', [ProfileController::class, 'editPassword'])
          ->name('password.edit');
     Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
          ->name('password.update');
     Route::get('/profile/verify-email', [ProfileController::class, 'show'])
          ->name('profile.verify-email');
});

/* ---------- Contacto y Mensajes ---------- */
Route::get('/contacto', [MensajeContactoController::class, 'create'])
     ->name('contacto.create');
Route::post('/contacto', [MensajeContactoController::class, 'store'])
     ->name('contacto.store');

// solo admin (autenticado) puede eliminar
Route::middleware('auth')->delete(
     '/contacto/{mensaje}',
     [MensajeContactoController::class, 'destroy']
)->name('contacto.destroy');

/* ---------- Legal ---------- */
Route::view('/legal', 'legal')
     ->name('legal');

/* ---------- Auth ---------- */
require __DIR__ . '/auth.php';
