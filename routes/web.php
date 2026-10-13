<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AnimalController;
use App\Services\AnimalServiceInterface;

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



Route::resource('animals', AnimalController::class);

// Ruta auxiliar didáctica para reiniciar los datos de prueba en la sesión del mock
Route::post('animals-reset', function (AnimalServiceInterface $service) {
    $service->reset();
    return redirect()->route('animals.index')->with('success', 'Datos de prueba reiniciados.');
})->name('animals.reset');

