<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Interfaces\HorarioServiceInterface;
use App\Http\Requests\StoreCita;
use App\Especialidad;
use Carbon\Carbon;
use App\Cita;
use App\CitaCancelada;
use Validator;

class CitaController extends Controller
{
    public function index()
    {   $rol = auth()->user()->rol;

        if($rol == 'administrador'){
            $citasPendientes = Cita::where('estado', 'Reservada')
            ->paginate(10);
    
            $citasConfirmadas = Cita::where('estado', 'Confirmada')
            ->paginate(10);
    
            $citasAntiguas = Cita::whereIn('estado', ['Atendida','Cancelada'])
            ->paginate(10);
        }

        if($rol == 'paciente'){
        $citasPendientes = Cita::where('estado', 'Reservada')
        ->where('paciente_id', auth()->id())->paginate(10);

        $citasConfirmadas = Cita::where('estado', 'Confirmada')
        ->where('paciente_id', auth()->id())->paginate(10);

        $citasAntiguas = Cita::whereIn('estado', ['Atendida','Cancelada'])
        ->where('paciente_id', auth()->id())->paginate(10);
    }

    if($rol == 'doctor'){
        $citasPendientes = Cita::where('estado', 'Reservada')
        ->where('doctor_id', auth()->id())->paginate(10);

        $citasConfirmadas = Cita::where('estado', 'Confirmada')
        ->where('doctor_id', auth()->id())->paginate(10);

        $citasAntiguas = Cita::whereIn('estado', ['Atendida','Cancelada'])
        ->where('doctor_id', auth()->id())->paginate(10);
    }

        return view('citas.index', compact('citasPendientes', 'citasConfirmadas', 'citasAntiguas','rol'));
    }
    public function create(HorarioServiceInterface $horarioService)
    {  
        $especialidades = Especialidad::all();
        $especialidadId = old('especialidad_id');

        if($especialidadId){
            $especialidad = Especialidad::find($especialidadId);
            $doctores = $especialidad->users;
        } else {
            $doctores = collect();
        }
            $fecha = old('fecha_programada');
            $doctorId = old('doctor_id');

            if($fecha && $doctorId){
                $intervalos = $horarioService->getIntervalosDisponibles($fecha, $doctorId);
            } else {
                $intervalos = null;
            }

    
        return view('citas.create', compact('especialidades','doctores', 'intervalos'));
    }
   
    public function store(StoreCita $request)
    {  
        $creado= Cita::creadoPorPaciente($request, auth()->id());
        
        if($creado)
            $notificacion = 'La cita se ha registrado correctamente';
        else
            $notificacion = 'Ocurrió un problema al registrar cita médica';
        return back()->with(compact('notificacion'));
        
    }

    public function show(Cita $cita){
        $rol = auth()->user()->rol;
        return view('citas.show', compact('cita', 'rol'));
    }

    public function postCancel(Cita $cita, Request $request){
        if($request->has('justificacion')){
          $cancelacion = new CitaCancelada();
          $cancelacion->justificacion = $request->input('justificacion');
          $cancelacion->cancelado_por_id = auth()->id();
          $cita->cancelacion()->save($cancelacion);

          }
          $cita->estado = 'Cancelada';
          $guardado= $cita->save();

        if($guardado)
            $cita->paciente->enviarFCM('Su cita ha sido cancelada!');

          $notificacion = 'La cita se ha cancelado correctamente';

          return redirect('/citas')->with(compact('notificacion'));
    }

    public function showCancelForm(Cita $cita) {
       
        $rol = auth()->user()->rol;
        return view('citas.cancel', compact('cita', 'rol'));
        
    }

    public function postConfirm(Cita $cita) {
        $cita->estado = 'Confirmada';
        $guardado= $cita->save();

        if($guardado)
            $cita->paciente->enviarFCM('Su cita se ha confirmado!');

        $notificacion = 'La cita se ha confirmado correctamente';

        return redirect('/citas')->with(compact('notificacion'));
        }
       
}