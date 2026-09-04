<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Definimos la ruta /usuarios que apunta al método index del UserController
Route::get('/usuarios', [UserController::class, 'index']);

Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{id}/edit', [MovieController::class, 'edit'])->name('movies.edit');
Route::put('/movies/{id}', [MovieController::class, 'update'])->name('movies.update');
