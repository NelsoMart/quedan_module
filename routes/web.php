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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route Hooks - Do not delete//
	Route::view('quedans', 'livewire.quedans.index')->middleware('auth');
	Route::view('quedanfacturas', 'livewire.quedanfacturas.index')->middleware('auth');
	Route::view('facturas', 'livewire.facturas.index')->middleware('auth');
	Route::view('proveedores', 'livewire.proveedores.index')->middleware('auth');
	Route::view('fuentes', 'livewire.fuentes.index')->middleware('auth');
	Route::view('proyectos', 'livewire.proyectos.index')->middleware('auth');
	Route::get('/print_quedan/{id}/{cant_num}', [App\Http\Controllers\PdfController::class, 'index'])->name('print_quedan');


