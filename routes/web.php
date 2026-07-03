<?php

use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnfermedadController;
use App\Http\Controllers\EstadisticaController;
use App\Http\Controllers\PacienteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/estadisticas', [EstadisticaController::class, 'index'])->name('estadisticas.index');

Route::prefix('pacientes')->group(function () {
    Route::get('/', [PacienteController::class, 'index'])->name('pacientes.index');
    Route::get('/crear', [PacienteController::class, 'create'])->name('pacientes.create');
    Route::post('/', [PacienteController::class, 'store'])->name('pacientes.store');
    Route::get('/{paciente}/editar', [PacienteController::class, 'edit'])->name('pacientes.edit');
    Route::put('/{paciente}', [PacienteController::class, 'update'])->name('pacientes.update');
    Route::delete('/{paciente}', [PacienteController::class, 'destroy'])->name('pacientes.destroy');
});

Route::prefix('consultas')->group(function () {
    Route::get('/', [ConsultaController::class, 'index'])->name('consultas.index');
    Route::get('/crear', [ConsultaController::class, 'create'])->name('consultas.create');
    Route::post('/', [ConsultaController::class, 'store'])->name('consultas.store');
});

Route::prefix('enfermedades')->group(function () {
    Route::get('/', [EnfermedadController::class, 'index'])->name('enfermedades.index');
    Route::get('/crear', [EnfermedadController::class, 'create'])->name('enfermedades.create');
    Route::post('/', [EnfermedadController::class, 'store'])->name('enfermedades.store');
    Route::get('/{enfermedad}/editar', [EnfermedadController::class, 'edit'])->name('enfermedades.edit');
    Route::put('/{enfermedad}', [EnfermedadController::class, 'update'])->name('enfermedades.update');
    Route::delete('/{enfermedad}', [EnfermedadController::class, 'destroy'])->name('enfermedades.destroy');
});
