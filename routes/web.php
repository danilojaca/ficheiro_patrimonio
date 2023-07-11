<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::middleware(['auth'])->get('/', function () {
    return redirect()->route('formulario.index');;
});

Auth::routes();
Route::middleware(['auth'])->resource('formulario', 'App\Http\Controllers\FormularioController');
Route::middleware(['auth'])->get('pdf/{unidade}/{sala}/{centro}/{siie}', 'App\Http\Controllers\PDFController@exportar')
       ->name('formulario.exportar');
Route::middleware(['auth'])->prefix('/registro')->group(function(){
Route::resource('inventario', 'App\Http\Controllers\InventarioController');
Route::resource('edificio', 'App\Http\Controllers\EdificioController');
Route::resource('bens', 'App\Http\Controllers\BenController');
});
Route::middleware(['auth'])->resource('logs', 'App\Http\Controllers\LogController');
Route::middleware(['auth'])->resource('logusers', 'App\Http\Controllers\LogUserController');
Route::middleware(['auth'])->prefix('/registro')->group(function(){
    Route::resource('roles', 'App\Http\Controllers\RoleController');
    Route::resource('users', 'App\Http\Controllers\UserController');
    Route::resource('unidades', 'App\Http\Controllers\RoleUnidadesController');
    
    });


Route::fallback( function(){
    echo 'Pagina Não Existe. <a href="'.route('formulario.index').'"> clique aqui </a> para ir para a pagina inicial';
});
