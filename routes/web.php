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
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::middleware(['auth', 'administrador'])->namespace('Administrador')->group(function(){
    //Especialidades
    Route::get('/especialidades', 'EspecialidadController@index')->name('index');
    Route::get('/especialidades/create', 'EspecialidadController@create')->name('create');
    Route::get('/especialidades/{especialidad}/edit', 'EspecialidadController@edit')->name('edit');
    Route::post('/especialidades', 'EspecialidadController@store')->name('store');
    Route::put('/especialidades/{especialidad}', 'EspecialidadController@update')->name('update');
    Route::delete('/especialidades/{especialidad}', 'EspecialidadController@destroy')->name('destroy');

    Route::get('/reportes/citas/linea', 'ReporteController@citas');
    Route::get('/reportes/doctores/barra', 'ReporteController@doctores');
    Route::get('/reportes/doctores/barra/data', 'ReporteController@doctoresJson');

    Route::post('/fcm/send', 'FirebaseController@enviarTodos');

    Route::resource('doctores', 'DoctorController');
    Route::resource('pacientes', 'PacienteController');
    
});


Route::middleware(['auth', 'doctor'])->namespace('Doctor')->group(function(){
    
    Route::get('/horarios', 'HorarioController@edit');
    Route::post('/horarios', 'HorarioController@store');
       
});

Route::middleware('auth')->group(function(){
    Route::get('/citas/create', 'CitaController@create');
    Route::post('/citas', 'CitaController@store');
    Route::get('/citas', 'CitaController@index');
    Route::get('/citas/{cita}', 'CitaController@show');
    Route::get('/citas/{cita}/cancel', 'CitaController@showCancelForm');
    Route::post('/citas/{cita}/cancel', 'CitaController@postCancel');
    Route::post('/citas/{cita}/confirm', 'CitaController@postConfirm');

    
});

    