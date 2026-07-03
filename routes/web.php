<?php

use Illuminate\Support\Facades\Route; // <--- Deja SOLO este aquí arriba

Route::get('/', function () {
    return view('welcome');
});

// Ruta para la vista principal (Index)
Route::get('/salud', function () {
    return view('index');
});

// Ruta para mostrar el formulario de creación
Route::get('/salud/crear', function () {
    return view('crear');
});

// Ruta para mostrar el formulario de edición
Route::get('/salud/editar', function () {
    return view('editar');
});