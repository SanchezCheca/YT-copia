<?php

use App\Http\Controllers\controladorPrincipal;
use Illuminate\Support\Facades\Route;

//-------------REGISTRO Y LOGIN
Route::get('/', function () {
    return view('inicio');
});

Route::get('/register', function() {
    return view('register');
});

Route::get('/login', function() {
    return view('login');
});

//-------------REGISTRO Y LOGIN
Route::post('register', [controladorPrincipal::class, 'registrarCuenta']);
Route::post('login', [controladorPrincipal::class, 'iniciarSesion']);
