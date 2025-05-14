<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;                                // ← importar Request
use Illuminate\Foundation\Auth\EmailVerificationRequest;     // ← importar EmailVerificationRequest
use App\Http\Controllers\{
    EspacioController,
    ReservaController,
    ResenaController,
    MensajeContactoController,
    PaymentController
};

/* ---------- Espacios, HOME, etc.  -------------------- */

// Público: listado y detalle
Route::get('/', [EspacioController::class, 'index'])
     ->name('espacios.index');
Route::resource('espacios', EspacioController::class)
     ->only(['index', 'show']);

/* ---------- Crear / almacenar Espacios (solo ADMIN en controlador) ----- */

// Mostrar el formulario de creación
Route::get('espacios/create', [EspacioController::class, 'create'])
     ->name('espacios.create');

// Procesar el formulario
Route::post('espacios', [EspacioController::class, 'store'])
     ->name('espacios.store');

/* ---------- Editar / actualizar / borrar / verificar Espacios --------- */

// Estas rutas quedan dentro de auth para redirigir a login si no estás identificado.
// Aún así, el controlador comprueba además el role===admin.
Route::middleware('auth')->group(function () {
    // Editar
    Route::get('espacios/{espacio}/edit', [EspacioController::class, 'edit'])
         ->name('espacios.edit');
    Route::put('espacios/{espacio}',        [EspacioController::class, 'update'])
         ->name('espacios.update');

    // Borrar
    Route::delete('espacios/{espacio}',     [EspacioController::class, 'destroy'])
         ->name('espacios.destroy');

    // Marcar como APTA / NO APTA
    Route::post('espacios/{espacio}/apta',   [EspacioController::class, 'markApta'])
         ->name('espacios.apta');
    Route::post('espacios/{espacio}/no-apta',[EspacioController::class, 'markNoApta'])
         ->name('espacios.no_apta');
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
// 

// Página de aviso para usuarios no verificados
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Procesa el enlace de verificación
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('profile.show')->with('status', 'Correo verificado correctamente.');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Reenvía el email de verificación
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'Se ha reenviado el correo de verificación.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

/* ---------- Perfil de usuario ----------------------- */
Route::middleware('auth')->group(function () {
    // Dashboard / Mi perfil
    Route::get('/dashboard', [ProfileController::class, 'show'])
         ->name('dashboard');
    Route::get('/profile',   [ProfileController::class, 'show'])
         ->name('profile.show');
    Route::get('/verify-email',   [ProfileController::class, 'show'])
         ->name('profile.verify-email');

    // Editar perfil
    Route::get('/profile/edit', [ProfileController::class, 'edit'])
         ->name('profile.edit');
    Route::put('/profile',      [ProfileController::class, 'update'])
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
