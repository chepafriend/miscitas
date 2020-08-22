<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Especialidad;

class EspecialidadController extends Controller
{
    public function index(){

        return Especialidad::all(['id', 'nombre']);
    }

    public function doctores(Especialidad $especialidad){

        return $especialidad->users()->get(['users.id', 'users.nombre']);
    }
}
