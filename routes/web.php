<?php
use Illuminate\Support\Facades\Route;
// TIP IMPORTANTE: No olvides importar el controlador aquí abajo
use App\Http\Controllers\UserController;
Route::get('/', function () {
 return view('welcome');
});
// Definimos la ruta /usuarios que apunta al método index del UserController
Route::get('/usuarios', [UserController::class, 'index']);