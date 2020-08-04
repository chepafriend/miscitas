<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Interfaces\HorarioServiceInterface;
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
   
    public function store(Request $request, HorarioServiceInterface $horarioService)
    {  
        $rules=[
            'descripcion'=>'required',
            'especialidad_id'=>'exists:especialidads,id',
            'doctor_id'=>'exists:users,id',
            'hora_programada'=>'required',
        ];
        $messages=[
            'hora_programada.required'=>"Seleccione una hora valida para su cita.",
               ];

        $validacion = Validator::make($request->all(), $rules, $messages);

        $validacion->after(function($validacion) use($request, $horarioService){

        $fecha = $request->input('fecha_programada');
        $doctorId = $request->input('doctor_id');
        $hora_programada = $request->input('hora_programada');

        if($fecha && $doctorId && $hora_programada){
            $inicio = new Carbon($hora_programada);
        } else {
            return;
        }

        if(!$horarioService->esIntervaloDisponible($fecha, $doctorId, $inicio)){

            $validacion->errors()
                ->add('hora_disponible', 'La hora seleccionada se encuentra reservada para otro paciente.');
            }
        });
            if($validacion->fails()){
                return back()
                        ->withErrors($validacion)
                        ->withInput();
                   } 

        $data = $request->only([
            'descripcion',
            'especialidad_id',
            'doctor_id',
            'fecha_programada',
            'hora_programada', 
            'tipo']); 
            $data['paciente_id']=auth()->id();

            $carbonHora = Carbon::createFromFormat('g:i A', $data['hora_programada']);
            $data['hora_programada']=$carbonHora->format('H:i:s');
            Cita::create($data);

        $notificacion = 'La cita se ha registrado correctamente';
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
          $cita->save();
          $notificacion = 'La cita se ha cancelado correctamente';

          return redirect('/citas')->with(compact('notificacion'));
    }

    public function showCancelForm(Cita $cita) {
       
        $rol = auth()->user()->rol;
        return view('citas.cancel', compact('cita', 'rol'));
        
    }

    public function postConfirm(Cita $cita) {
        $cita->estado = 'Confirmada';
        $cita->save();
        $notificacion = 'La cita se ha confirmado correctamente';

          return redirect('/citas')->with(compact('notificacion'));
        }
       
}