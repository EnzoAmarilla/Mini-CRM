<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false, 'reset' => false]);

Route::get('/home', 'HomeController@index')->name('home');

// Empresas
Route::resource('empresas', 'EmpresasController')->middleware('auth');
Route::get('/getDataEmpresa/{id}', 'EmpresasController@getDataEmpresa')->middleware('auth');

// Empleados
Route::resource('empleados', 'EmpleadosController')->middleware('auth');
Route::get('/getDataEmpleado/{id}', 'EmpleadosController@getDataEmpleado')->middleware('auth');
