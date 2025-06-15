

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/* ── Controladores de la parte pública ─────────────────────────── */
use App\Http\Controllers\{
    EspacioController,
    ReservaController,
    ResenaController,
    MensajeContactoController,
    HomeController,
    ProfileController
};

/* ── Controlador de la zona admin ──────────────────────────────── */
use App\Http\Controllers\Admin\ResenaController as AdminResenaController;

/*------------------------------------------------------------------
 | HOME
 *-----------------------------------------------------------------*/

Route::get('/', [HomeController::class, 'index'])->name('index');

/*------------------------------------------------------------------
 | ESPACIOS
 *-----------------------------------------------------------------*/
/*  Público  */
Route::get('espacios',           [EspacioController::class, 'index'])->name('espacios.index');
Route::get('espacios/{espacio}', [EspacioController::class, 'show'])
     ->whereNumber('espacio')->name('espacios.show');

Route::get('espacios/{espacio}/reserved-intervals', [ReservaController::class, 'reservedIntervals'])
     ->name('reservas.reservedIntervals');

/*  Privado  */
Route::middleware('auth')->group(function () {
    Route::get('espacios/create',        [EspacioController::class, 'create'])->name('espacios.create');
    Route::post('espacios',              [EspacioController::class, 'store'])->name('espacios.store');
    Route::get('espacios/{espacio}/edit',[EspacioController::class, 'edit'])
         ->whereNumber('espacio')->name('espacios.edit');
    Route::put('espacios/{espacio}',     [EspacioController::class, 'update'])
         ->whereNumber('espacio')->name('espacios.update');
    Route::delete('espacios/{espacio}',  [EspacioController::class, 'destroy'])
         ->whereNumber('espacio')->name('espacios.destroy');

    Route::post('espacios/{espacio}/apta',    [EspacioController::class, 'markApta'])
         ->whereNumber('espacio')->name('espacios.apta');
    Route::post('espacios/{espacio}/no-apta', [EspacioController::class, 'markNoApta'])
         ->whereNumber('espacio')->name('espacios.no_apta');
});

/* Horas disponibles (AJAX público) */
Route::get('api/espacios/{espacio}/horas', [ReservaController::class, 'availableHours'])
     ->whereNumber('espacio')->name('reservas.availableHours');

/*------------------------------------------------------------------
 | RESERVAS
 *-----------------------------------------------------------------*/
Route::middleware('auth')->group(function () {
    // Crear y almacenar reserva
    Route::get('espacios/{espacio}/reservar',  [ReservaController::class, 'create'])
         ->whereNumber('espacio')->name('reservas.create');
    Route::post('espacios/{espacio}/reservar', [ReservaController::class, 'store'])
         ->whereNumber('espacio')->name('reservas.store');

    // Pago
    Route::get('reservas/{reserva}/pagar', [ReservaController::class, 'pay'])
         ->whereNumber('reserva')->name('reservas.pay');

    // Editar / actualizar / eliminar
    Route::get('reservas/{reserva}/edit', [ReservaController::class, 'edit'])
         ->whereNumber('reserva')->name('reservas.edit');
    Route::put('reservas/{reserva}',      [ReservaController::class, 'update'])
         ->whereNumber('reserva')->name('reservas.update');
    Route::delete('reservas/{reserva}',   [ReservaController::class, 'destroy'])
         ->whereNumber('reserva')->name('reservas.destroy');

    // AJAX rápido
    Route::post('reservas/ajax',          [ReservaController::class, 'storeAjax'])
         ->name('reservas.ajax');

    // Cancelar reserva (DELETE)
    Route::delete('reservas/{reserva}/cancelar', [ReservaController::class, 'cancelar'])
         ->whereNumber('reserva')->name('reservas.cancelar');

    // Marcar como pagado
    Route::put('reservas/{reserva}/pagado', [ReservaController::class, 'markPaid'])
         ->whereNumber('reserva')->name('reservas.markPaid');
});

// Listado y detalle accesibles sin necesidad de auth
Route::get('reservas',           [ReservaController::class, 'index'])
     ->name('reservas.index');
Route::get('reservas/{reserva}', [ReservaController::class, 'show'])
     ->whereNumber('reserva')->name('reservas.show');

/*------------------------------------------------------------------
 | RESEÑAS  (públicas / de usuario autenticado)
 *-----------------------------------------------------------------*/
Route::get('resenas',           [ResenaController::class, 'index'])->name('resenas.index');
Route::get('resenas/{resena}',  [ResenaController::class, 'show'])
     ->whereNumber('resena')->name('resenas.show');

Route::middleware('auth')->group(function () {
    Route::get('resenas/create',             [ResenaController::class, 'create'])->name('resenas.create');
    Route::post('resenas',                   [ResenaController::class, 'store'])->name('resenas.store');
    Route::get('resenas/{resena}/edit',      [ResenaController::class, 'edit'])
         ->whereNumber('resena')->name('resenas.edit');
    Route::put('resenas/{resena}',           [ResenaController::class, 'update'])
         ->whereNumber('resena')->name('resenas.update');
    Route::delete('resenas/{resena}',        [ResenaController::class, 'destroy'])
         ->whereNumber('resena')->name('resenas.destroy');
    Route::post('resenas/{resena}/visible',  [ResenaController::class, 'makeVisible'])
         ->whereNumber('resena')->name('resenas.visible');
});

/*------------------------------------------------------------------
 | VERIFICACIÓN DE CORREO
 *-----------------------------------------------------------------*/
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

/*------------------------------------------------------------------
 | PERFIL
 *-----------------------------------------------------------------*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard',        [ProfileController::class, 'show'])->name('dashboard');
    Route::get('/profile',          [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit',     [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',          [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password.edit');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

/*------------------------------------------------------------------
 | CONTACTO
 *-----------------------------------------------------------------*/
Route::get('/contacto',  [MensajeContactoController::class, 'create'])->name('contacto.create');
Route::post('/contacto', [MensajeContactoController::class, 'store'])->name('contacto.store');
Route::middleware('auth')->delete('/contacto/{mensaje}', [MensajeContactoController::class, 'destroy'])
     ->whereNumber('mensaje')->name('contacto.destroy');

/*------------------------------------------------------------------
 | LEGAL
 *-----------------------------------------------------------------*/
Route::view('/legal', 'legal')->name('legal');

/*------------------------------------------------------------------
 | AUTH SCAFFOLD
 *-----------------------------------------------------------------*/
require __DIR__ . '/auth.php';
