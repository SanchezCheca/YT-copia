<?php

use App\Http\Controllers\contentController;
use App\Http\Controllers\controladorPrincipal;
use App\Http\Controllers\loginController;
use Illuminate\Support\Facades\Route;



Route::get('register', function() {
    return view('register');
});

Route::get('/login', function() {
    return view('login');
});

//------------PRINCIPAL
Route::get('/', [controladorPrincipal::class, 'inicio']);
Route::get('inicio', [controladorPrincipal::class, 'inicio']);
//Route::get('upload', [controladorPrincipal::class, 'aUpload']);

//------------CONTENIDO
Route::get('user/{username}', [contentController::class, 'verCanal']);
Route::get('upload', [contentController::class, 'aUpload']);
Route::post('upload', [contentController::class, 'upload']);
Route::get('video/{filename}', [contentController::class, 'verVideo']);
Route::get('videoExample', [contentController::class, 'videoExample']);

//-------------REGISTRO Y LOGIN
Route::post('register', [loginController::class, 'registrarCuenta']);
Route::post('login', [loginController::class, 'iniciarSesion']);
Route::get('cerrarSesion', [loginController::class, 'cerrarSesion']);
