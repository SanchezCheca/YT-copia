<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\contentController;
use App\Http\Controllers\controladorPrincipal;
use App\Http\Controllers\loginController;
use Illuminate\Support\Facades\Route;

//------------PRINCIPAL
Route::get('/', [controladorPrincipal::class, 'inicio'])->middleware('controlarRutaActual');
Route::get('inicio', [controladorPrincipal::class, 'inicio'])->middleware('controlarRutaActual');
//Route::get('upload', [controladorPrincipal::class, 'aUpload']);
Route::get('login', [controladorPrincipal::class, 'aLogin']);
Route::get('register', [controladorPrincipal::class, 'aRegister']);

//------------CONTENIDO
Route::get('user/{username}', [contentController::class, 'verCanal'])->middleware('controlarRutaActual');
Route::get('upload', [contentController::class, 'aUpload'])->middleware('auth');
Route::post('upload', [contentController::class, 'upload']);
Route::get('video/{filename}', [contentController::class, 'verVideo'])->middleware('controlarRutaActual');
Route::get('videoExample', [contentController::class, 'videoExample']);
Route::get('likeVideo/{filename}', [contentController::class, 'likeVideo']);
Route::get('dislikeVideo/{filename}', [contentController::class, 'dislikeVideo']);
Route::post('subscribe/{username}', [contentController::class, 'subscribe']);
Route::get('user/{username}/videos', [contentController::class, 'verVideosCanal'])->middleware('controlarRutaActual');
Route::get('editProfile', [contentController::class, 'aEditProfile']);
Route::post('editProfile', [contentController::class, 'editProfile']);
Route::get('video/{filename}/edit', [contentController::class, 'aEditarVideo']);
Route::post('editVideo', [contentController::class, 'editarVideo']);

//-------------REGISTRO Y LOGIN
Route::post('register', [loginController::class, 'registrarCuenta']);
Route::post('login', [loginController::class, 'iniciarSesion']);
Route::get('cerrarSesion', [loginController::class, 'cerrarSesion']);

//-------------ADMINISTRACIÓN
Route::get('crud', [adminController::class, 'aCrud']);
Route::post('editUserCRUD', [adminController::class, 'editUserCRUD']);
