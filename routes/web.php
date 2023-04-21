<?php

use Illuminate\Support\Facades\Route;

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
    return view('home');
});

Auth::routes();
Route::resource('/formulario', 'App\Http\Controllers\FormularioController');
Route::get('/pdf/{unidade}/{sala}/{centro}/{siie}', 'App\Http\Controllers\PDFController@exportar')
       ->name('formulario.exportar');
Route::prefix('/registro')->group(function(){
Route::resource('/inventario', 'App\Http\Controllers\InventarioController');
Route::resource('/edificio', 'App\Http\Controllers\EdificioController');
Route::resource('/bens', 'App\Http\Controllers\BenController');
});
Route::fallback( function(){
    echo 'Pagina Não Existe. <a href="'.route('index').'"> clique aqui </a> para ir para a pagina inicial';
});
