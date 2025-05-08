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


// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [EspacioController::class, 'index'])->name('espacios.index');
Route::get('espacios/{id}', [EspacioController::class, 'show'])->name('espacios.show');
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
Route::middleware('auth')->group(function(){
    Route::resource('reservas', ReservaController::class)->only(['index', 'store', 'destroy']);
    Route::resource('resenas', ResenaController::class)->only(['index', 'store', 'destroy']);
    
    // Rutas para el formulario de contacto
    Route::get('contacto', [MensajeContactoController::class, 'create'])->name('contacto.create');
    Route::post('contacto', [MensajeContactoController::class, 'store'])->name('contacto.store');
  
    // Stripe
    Route::post('checkout', [PaymentController::class, 'checkout'])->name('checkout');
    Route::post('webhook', [PaymentController::class, 'webhook'])->name('stripe.webhook');
  });
  
  Route::middleware(['auth', 'can:admin'])->prefix('admin')->group(function(){
    Route::get('dashboard', [EspacioController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::resource('espacios', EspacioController::class)->except(['index', 'show']);
    Route::resource('resenas', ResenaController::class)->only(['destroy']);
  });
  
require __DIR__.'/auth.php';
