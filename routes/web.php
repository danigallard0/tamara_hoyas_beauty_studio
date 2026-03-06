<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ServicioController;
use App\Http\Controllers\Admin\HorarioController;

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

require __DIR__.'/auth.php';
