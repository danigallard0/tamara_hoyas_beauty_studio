<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ServicioController;
use App\Http\Controllers\Admin\HorarioController;
use App\Http\Controllers\Cliente\CitaController;
use App\Http\Controllers\Web\ServicioPubliController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    //Si el usuario es admin lo llevamos al panel de admin
    if($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    //Si no es admin, lo tratamos como cliente
    return redirect()->route('cliente.dashboard');
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

        //Mostrar FullCalendar
        Route::get('/calendario', [App\Http\Controllers\Admin\CalendarioController::class, 'index'])
            ->name('calendario.index');
        Route::get('/calendario/eventos', [App\Http\Controllers\Admin\CalendarioController::class, 'eventos'])
            ->name('calendario.eventos');
        
        //Editar citas desde el calendario
        Route::get('/citas/{cita}/edit', [App\Http\Controllers\Admin\CitaController::class, 'edit'])
            ->name('citas.edit');
        Route::put('/citas/{cita}', [App\Http\Controllers\Admin\CitaController::class, 'update'])
            ->name('citas.update');

        //Facturas
        Route::post('/citas/{cita}/factura', [App\Http\Controllers\Admin\FacturaController::class, 'store'])
            ->name('facturas.store');
        Route::get('/facturas/{factura}', [App\Http\Controllers\Admin\FacturaController::class, 'show'])
            ->name('facturas.show');
        
        //Pagos
        Route::post('/facturas/{factura}/pagos', [App\Http\Controllers\Admin\PagoController::class, 'store'])
            ->name('pagos.store');

        //Imprimir
        Route::get('/facturas/{factura}/imprimir', [App\Http\Controllers\Admin\FacturaController::class, 'imprimir'])
            ->name('facturas.imprimir');
});

Route::middleware(['auth'])->prefix('cliente')->name('cliente.')->group(function () {
    Route::get('/', function() {
        return view('cliente.dashboard');
    })->name('dashboard');

    Route::get('/citas/create', [CitaController::class, 'create'])->name('citas.create');
    Route::post('/citas', [CitaController::class, 'store'])->name('citas.store'); 
    Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');
    Route::delete('/citas/{cita}', [CitaController::class, 'destroy'])->name('citas.destroy');
    Route::get('/fechas-disponibles', [App\Http\Controllers\Cliente\CitaController::class, 'fechasDisponibles'])
    ->name('citas.fechas-disponibles');
    Route::get('/citas/horas-disponibles', [CitaController::class, 'horasDisponibles'])->name('citas.horas-disponibles');

    Route::get('/citas/{cita}/pago', [CitaController::class, 'pago'])->name('citas.pago');
    Route::post('/citas/{cita}/pagar', [CitaController::class, 'procesarPago'])->name('citas.pagar');
});

Route::get('/servicios', function () {
    return view('servicios.index');
})->name('servicios.index');

Route::get('/servicios/cejas', function () {
    return view('servicios.cejas');
})->name('servicios.cejas');

Route::get('/servicios/ojos', function () {
    return view('servicios.ojos');
})->name('servicios.ojos');
Route::get('/servicios/labios', function () {
    return view('servicios.labios');
})->name('servicios.labios');

Route::get('/servicios/areolas', function () {
    return view('servicios.areolas');
})->name('servicios.areolas');

Route::get('/servicios/maquillaje', function () {
    return view('servicios.maquillaje');
})->name('servicios.maquillaje');

require __DIR__.'/auth.php';
