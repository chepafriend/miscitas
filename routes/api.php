<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/especialidades', 'EspecialidadController@index');
Route::get('/especialidades/{especialidad}/doctores', 'EspecialidadController@doctores');
Route::get('/horarios/horas', 'HorarioController@horas');
Route::post('/login', 'AuthController@login');
Route::post('/registro', 'AuthController@registro');

Route::group([
    'prefix' => 'auth'
], function () {
    

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::post('/logout', 'AuthController@logout');
        Route::get('/user', 'UserController@show');

        Route::get('/citas', 'CitasController@index');
        Route::post('/citas', 'CitasController@store');

        Route::post('/fcm/token', 'FirebaseController@postToken');
    });
});
