<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCita;
use App\Cita;
use Auth;

class CitasController extends Controller
{
    public function index(){

        $user= Auth::user();
        
        return $user->citasPacientes()
        ->with(['especialidad'=>function($query){
            $query->select('id','nombre');
        }, 'doctor'=>function($query){
            $query->select('id','nombre');
        }])
        ->get([
        "id",
        "descripcion",
        "especialidad_id",
        "doctor_id",
        "fecha_programada",
        "hora_programada",
        "tipo",
        "created_at",
        "estado"]);
    }
    public function store(StoreCita $request){

        $exito= Cita::creadoPorPaciente($request, auth()->id());

        return compact('exito');
    }
}
