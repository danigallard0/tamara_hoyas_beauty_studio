<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ServicioController;
use App\Http\Controllers\Admin\HorarioController;
use App\Http\Controllers\Cliente\CitaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        //Dashboard admin
        Route::get('/', function() {
            return view('admin.dashboard');
        })->name('dashboard');

        //CRUD Servicios
        Route::resource('servicios', ServicioController::class);

        //CRUD Horarios
        Route::resource('horarios', HorarioController::class);
});

Route::middleware(['auth'])->prefix('cliente')->name('cliente.')->group(function () {
    Route::get('/citas/create', [CitaController::class, 'create'])->name('citas.create');
    Route::post('/citas', [CitaController::class, 'store'])->name('citas.store'); 
    Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');
    Route::delete('/citas/{cita}', [CitaController::class, 'destroy'])->name('citas.destroy');
    Route::get('/citas/horas-disponibles', [CitaController::class, 'horasDisponibles'])->name('citas.horas-disponibles');
});


require __DIR__.'/auth.php';
