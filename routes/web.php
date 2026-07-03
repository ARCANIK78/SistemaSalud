<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnfermedadController;
use App\Http\Controllers\EstadisticaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/estadisticas', [EstadisticaController::class, 'index'])->name('estadisticas.index');

Route::prefix('enfermedades')->group(function () {
    Route::get('/', [EnfermedadController::class, 'index'])->name('enfermedades.index');
    Route::get('/crear', [EnfermedadController::class, 'create'])->name('enfermedades.create');
    Route::post('/', [EnfermedadController::class, 'store'])->name('enfermedades.store');
    Route::get('/{enfermedad}/editar', [EnfermedadController::class, 'edit'])->name('enfermedades.edit');
    Route::put('/{enfermedad}', [EnfermedadController::class, 'update'])->name('enfermedades.update');
    Route::delete('/{enfermedad}', [EnfermedadController::class, 'destroy'])->name('enfermedades.destroy');
});
