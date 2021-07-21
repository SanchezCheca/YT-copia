<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\contentController;
use App\Http\Controllers\controladorPrincipal;
use App\Http\Controllers\loginController;
use Illuminate\Support\Facades\Route;

//------------PRINCIPAL
Route::get('/', [controladorPrincipal::class, 'inicio'])->middleware('controlarRutaActual');
Route::get('inicio', function () {
    return redirect('/');
});
//Route::get('upload', [controladorPrincipal::class, 'aUpload']);
Route::get('login', [controladorPrincipal::class, 'aLogin']);
Route::get('register', [controladorPrincipal::class, 'aRegister']);
Route::get('ranking', [controladorPrincipal::class, 'aRanking'])->middleware('controlarRutaActual');
Route::get('contacto', [controladorPrincipal::class, 'aContacto'])->middleware('controlarRutaActual');
Route::post('contacto', [controladorPrincipal::class, 'procesarContacto']);
Route::get('notificaciones', [controladorPrincipal::class, 'aNotificaciones'])->middleware('controlarRutaActual');

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
Route::get('search/{searchTerm}', [contentController::class, 'search'])->middleware('controlarRutaActual');
Route::get('search', [contentController::class, 'searchEmpty'])->middleware('controlarRutaActual');
Route::post('processSearch', [contentController::class, 'processSearch']);
Route::get('mySubs', [contentController::class, 'mySubs'])->middleware('controlarRutaActual');
Route::post('comentar', [contentController::class, 'commentVideo']);

//-------------REGISTRO Y LOGIN
Route::post('register', [loginController::class, 'registrarCuenta']);
Route::post('login', [loginController::class, 'iniciarSesion']);
Route::get('cerrarSesion', [loginController::class, 'cerrarSesion']);

//-------------ADMINISTRACIÓN
Route::get('crud', [adminController::class, 'aCrud'])->middleware('controlarRutaActual');
Route::post('editUserCRUD', [adminController::class, 'editUserCRUD']);
Route::get('verContactos', [adminController::class, 'verContactos']);
Route::get('crearNotificacion', [adminController::class, 'aCrearNotificacion'])->middleware('controlarRutaActual');
Route::post('crearNotificacion', [adminController::class, 'crearNotificacion']);
