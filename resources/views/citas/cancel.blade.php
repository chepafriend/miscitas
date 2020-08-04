@extends('layouts.panel')

@section('content')
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Cancelar Citas</h3>
                </div>
                </div>
            </div>

            <div class="card-body">
            @if (session('notificacion'))
            <div class="alert alert-success" role="alert">
            {{session('notificacion')}}
            </div>
            @endif 
            <form method="POST" action="{{url('citas/'.$cita->id.'/cancel')}}">
            @csrf
            @if($rol=='paciente')
            <p> Estás a punto de cancelar tu cita reservada con el médico {{$cita->doctor->nombre}}
            (especialidad {{$cita->especialidad->nombre}}) para el día {{$cita->fecha_programada}} (hora {{$cita->hora_programada_12}}): </p>
            
            @elseif($rol=='doctor')
            <p> Estás a punto de cancelar la cita reservada con el paciente {{$cita->paciente->nombre}}
            (especialidad {{$cita->especialidad->nombre}}) para el día {{$cita->fecha_programada}} (hora {{$cita->hora_programada_12}}): </p>
            
            @else
            <p> Estás a punto de cancelar la cita reservada por el paciente {{$cita->paciente->nombre}} para el médico {{$cita->doctor->nombre}}
            (especialidad {{$cita->especialidad->nombre}}) para el día {{$cita->fecha_programada}} (hora {{$cita->hora_programada_12}}): </p>
            @endif
            <div class="form-group">
            <label for="justificacion">Por favor comentar el motivo de la cancelación</label>
            <textarea name="justificacion" rows="3" class="form-control" required></textarea>
            </div>                   
            <button type="submit" class="btn btn-danger">Cancelar Cita</button>
            <a href="{{url('/citas')}}" class="btn btn-default">Volver al listado de citas sin cancelar
            </a>
            </form>             
            </div>                      
            </div>  
@endsection
