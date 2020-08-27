<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Interfaces\HorarioServiceInterface;
use App\Dialaborable;
use Carbon\Carbon;

class HorarioController extends Controller
{
    private  function performValidation(Request $request){
        $rules=[
            'fecha'=>'required|date_format:"Y-m-d"',
            'doctor_id'=>'required|exists:users,id'
        ];
        
        $request->validate($rules);

    }

    public function horas(Request $request, HorarioServiceInterface $horarioService){
        
        $this->performValidation($request);

        $fecha = $request->input('fecha');
        $doctorId = $request->input('doctor_id');
       
        return $horarioService->getIntervalosDisponibles($fecha, $doctorId);
    }

}