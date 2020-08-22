<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/especialidades', 'EspecialidadController@index');
Route::get('/especialidades/{especialidad}/doctores', 'EspecialidadController@doctores');
Route::get('/horarios/horas', 'HorarioController@horas');

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/login', 'AuthController@login');
    Route::post('signup', 'AuthController@signUp');
    

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::post('/logout', 'AuthController@logout');
        Route::get('/user', 'UserController@show');
    });
});
