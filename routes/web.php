<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Definimos la ruta /usuarios que apunta al método index del UserController
Route::get('/usuarios', [UserController::class, 'index']);

Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');
Route::get('/movies/{id}/edit', [MovieController::class, 'edit'])->name('movies.edit');
Route::put('/movies/{id}', [MovieController::class, 'update'])->name('movies.update');
Route::delete('/movies/{id}', [MovieController::class, 'destroy'])->name('movies.destroy');

Route::get('/animals', [AnimalController::class, 'index'])->name('animals.index');
Route::get('/animals/create', [AnimalController::class, 'create'])->name('animals.create');
Route::post('/animals', [AnimalController::class, 'store'])->name('animals.store');
Route::get('/animals/{id}/edit', [AnimalController::class, 'edit'])->name('animals.edit');
Route::put('/animals/{id}', [AnimalController::class, 'update'])->name('animals.update');
Route::delete('/animals/{id}', [AnimalController::class, 'destroy'])->name('animals.destroy');
