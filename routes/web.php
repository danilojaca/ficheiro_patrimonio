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
Route::middleware(['auth'])->get('/home', function () {
    return redirect()->route('formulario.index');;
});

Auth::routes();
Route::middleware(['auth'])->resource('formulario', 'App\Http\Controllers\FormularioController');
Route::middleware(['auth'])->get('pdf/{unidade_id}/{sala}/{centro}/{siie}', 'App\Http\Controllers\PDFController@exportar')
       ->name('formulario.exportar');
Route::middleware(['auth'])->get('pdfrelatorio/{arrayrelatorio}', 'App\Http\Controllers\PDFRelatorioController@exportar')
       ->name('relatorio.exportar');       
Route::middleware(['auth'])->prefix('/registro')->group(function(){
Route::resource('inventario', 'App\Http\Controllers\InventarioController');
Route::resource('edificio', 'App\Http\Controllers\EdificioController');
Route::get('edificio/salas/{edificio}', 'App\Http\Controllers\EdificioController@salas')->name('edificio.salas');
Route::post('edificio/salas', 'App\Http\Controllers\EdificioController@salaupdate')->name('edificio.salaupdate');
Route::delete('edificio/salas/{sala}', 'App\Http\Controllers\EdificioController@saladelete')->name('edificio.saladelete');
Route::resource('bens', 'App\Http\Controllers\BenController');
Route::resource('unidade', 'App\Http\Controllers\UnidadesController');
Route::get('unidade/salas/{unidade}', 'App\Http\Controllers\UnidadesController@salas')->name('unidade.salas');
Route::patch('unidade/salas/{unidade}/{edificio_id}', 'App\Http\Controllers\UnidadesController@salasupdate')->name('unidade.salasupdate');
Route::resource('inventariomultiplos', 'App\Http\Controllers\InventarioMultiplosController');
});
Route::middleware(['auth'])->resource('logs', 'App\Http\Controllers\LogController');
Route::middleware(['auth'])->resource('logusers', 'App\Http\Controllers\LogUserController');
Route::middleware(['auth'])->resource('relatorio', 'App\Http\Controllers\RelatorioController');
Route::middleware(['auth'])->prefix('/registro')->group(function(){
    Route::resource('roles', 'App\Http\Controllers\RoleController');
    Route::resource('users', 'App\Http\Controllers\UserController');
    Route::resource('roleunidades', 'App\Http\Controllers\RoleUnidadesController');
    Route::get('roles_salas', 'App\Http\Controllers\RoleUnidadesController@roleclass')->name('roleclass');
    Route::post('roles_salas', 'App\Http\Controllers\RoleUnidadesController@roleclassupdate')->name('roleclassupdate');
    
    });


Route::fallback( function(){
    echo 'Pagina Não Existe. <a href="'.route('formulario.index').'"> clique aqui </a> para ir para a pagina inicial';
});
