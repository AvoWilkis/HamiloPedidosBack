<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NegociosController;
use App\Http\Controllers\ProductosController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect('/login');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/verificar', [App\Http\Controllers\HomeController::class, 'verificar'])->name('verificarOTP');
Route::get('/reenviar', [App\Http\Controllers\HomeController::class, 'reenviar'])->name('reenviarOTP');

//RUTAS PARA NEGOCIOS
Route::get('/negocios', [NegociosController::class, 'index']);
Route::get('/negocios/registrar', [NegociosController::class, 'create']);
Route::post('/negocios/registrar', [NegociosController::class, 'store']);
Route::get('/negocios/actualizar/{id}', [NegociosController::class, 'edit']);
Route::put('/negocios/actualizar/{id}', [NegociosController::class, 'update']);
Route::get('/negocios/estado/{id}', [NegociosController::class, 'estado']);
Route::get('/negocios/ver/{id}', [NegociosController::class, 'show']);

//Rutas para productos
Route::get('/productos', [ProductosController::class, 'index']);
Route::get('/productos/registrar', [ProductosController::class, 'create']);
Route::post('/productos/registrar', [ProductosController::class, 'store']);
Route::get('/productos/actualizar/{id}', [ProductosController::class, 'edit']);
Route::put('/productos/actualizar/{id}', [ProductosController::class, 'update']);
Route::get('/productos/estado/{id}', [ProductosController::class, 'estado']);


});








