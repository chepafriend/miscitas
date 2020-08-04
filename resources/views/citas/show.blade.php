@extends('layouts.panel')

@section('content')
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Cita #{{$cita->id}}</h3>
                </div>
               
              </div>
            </div>

            <div class="card-body">
            <ul>
            <li><strong>Fecha: </strong>{{$cita->fecha_programada}}
            </li>
            <li><strong>Hora: </strong>{{$cita->hora_programada_12}}
            </li>            
            <li>
            @if($rol == 'paciente' || $rol == 'administrador')
            <strong>Medico: </strong>{{$cita->doctor->nombre}}
            @endif
            </li>            
            <li>
            @if($rol == 'doctor' || $rol == 'administrador')
            <strong>Paciente: </strong>{{$cita->paciente->nombre}}
            @endif             
            </li>
            <li><strong>Especialidad: </strong>{{$cita->especialidad->nombre}}
            </li>
            <li><strong>Tipo: </strong>{{$cita->tipo}}
            </li>
            <li><strong>Estado: </strong>
            @if ($cita->estado == 'Cancelada')
            <span class= "badge badge-danger"> Cancelada</span>
            @else
            <span class= "badge badge-success"> {{$cita->estado}}</span>
            @endif
            </li>
            </ul>
            @if ($cita->estado == 'Cancelada')
            <div class= "alert alert-warning">
            <p> Acerca de la Cancelación</p>
            <ul>
            @if($cita->cancelacion)
            <li><strong>Motivo de Cancelacion: </strong>
            {{$cita->cancelacion->justificacion}}</li>
            <li><strong>Fecha de Cancelacion: </strong>
            {{$cita->cancelacion->created_at}}</li>
            <li><strong>¿Quién canceló la cita?: </strong>
            @if(auth()->id() == $cita->cancelacion->cancelado_por_id)
            Tú
            @else
            {{$cita->cancelacion->cancelado_por->nombre}}
            @endif            
            </li>            
            @else
            <li>Esta cita fue cancelada antes de su confirmación</li>
            @endif
            </ul>
            </div>
            @endif 
            <a href="{{url('/citas/')}}" class= "btn btn-default">
            Volver</a>
               
                 
            </div>  
@endsection