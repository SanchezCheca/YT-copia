<?php

use App\Http\Controllers\contentController;
use App\Http\Controllers\controladorPrincipal;
use App\Http\Controllers\loginController;
use Illuminate\Support\Facades\Route;

Route::get('/', [controladorPrincipal::class, 'inicio']);

Route::get('/register', function() {
    return view('register');
});

Route::get('/login', function() {
    return view('login');
});

//------------CONTENIDO
Route::get('user/{username}', [contentController::class, 'verCanal']);

//-------------REGISTRO Y LOGIN
Route::post('register', [loginController::class, 'registrarCuenta']);
Route::post('login', [loginController::class, 'iniciarSesion']);
Route::get('cerrarSesion', [loginController::class, 'cerrarSesion']);
