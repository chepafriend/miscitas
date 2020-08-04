@extends('layouts.panel')

@section('content')
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Registrar Nueva Cita</h3>
                </div>
                <div class="col text-right">
                  <a href="{{url('pacientes')}}" class="btn btn-sm btn-default">Cancelar y volver</a>
                </div>
              </div>
            </div>
            <div class="card-body">
            @if (session('notificacion'))
            <div class="alert alert-success" role="alert">
            {{session('notificacion')}}
            </div>
            @endif 
            @if($errors->any())
            <div class="alert alert-danger" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
            </div>
            @endif           
            <form method="POST" action="{{url('citas')}}">
              @csrf
              <div class="form-group">
              <label for= "descripcion">Descripción</label>
              <input name="descripcion" id="descripcion"
              class= "form-control" type= "text" value="{{old('descripcion')}}"
              placeholder= "Describe brevemente la consulta..." required>              
              </div>
              <div class="form-row">
              <div class="form-group col-md-6">
              <label for= "especialidad"> Especialidad</label>
              <select name= "especialidad_id" id= "especialidad" class= "form-control" required>
              <option value= "">Seleccionar Especialidad</option>
                @foreach($especialidades as $especialidad)
                    <option value= "{{ $especialidad->id }}" @if(old('especialidad_id')==$especialidad->id) selected @endif>{{ $especialidad->nombre }} 
                    </option>
                @endforeach
               </select>           
              </div>
              <div class="form-group col-md-6">
              <label for= "doctor"> Medico </label>
              <select name= "doctor_id" id= "doctor" class= "form-control">
              @foreach($doctores as $doctor)
                    <option value= "{{ $doctor->id }}" @if(old('doctor_id')==$doctor->id) selected @endif>{{ $doctor->nombre }} 
                    </option>
                @endforeach
               </select>           
              </div>
          </div>  
          <div class="form-group">
            <label for= "fecha"> Fecha </label>
            <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i>
                </span>
            </div>
            <input name="fecha_programada" value="{{old('fecha_programada', date('Y-m-d'))}}"
            class="form-control datepicker" placeholder="Seleccionar Fecha" 
            id="fecha" type="text" value= "{{date('Y-m-d')}}" data-date-format= "yyyy-mm-dd"
            data-date-start-date= "{{date('Y-m-d')}}" data-date-end-date= "+30d">
            </div>
            </div>
              <div class="form-group">
              <label for= "horas">Horas de Atención</label>
              <div id="horas">
              @if ($intervalos)
              @foreach ($intervalos['manana'] as $clave=>$intervalo)
              <div class= "custom-control custom-radio mb-3">
              <input name= "hora_programada" class= "custom-control-input"
              id= "intervaloManana{{$clave}}" type= "radio" value= "{{$intervalo['inicio']}}" required>
              <label class="custom-control-label" for= "intervaloManana{{$clave}}">
              {{$intervalo['inicio']}} - {{$intervalo['fin']}} </label>
              </div>
              @endforeach
              @foreach ($intervalos['tarde'] as $clave=>$intervalo)
              <div class= "custom-control custom-radio mb-3">
              <input name= "hora_programada" class= "custom-control-input"
              id= "intervaloTarde{{$clave}}" type= "radio" value= "{{$intervalo['inicio']}}" required>
              <label class="custom-control-label" for= "intervaloTarde{{$clave}}">
              {{$intervalo['inicio']}} - {{$intervalo['fin']}}</label>
              </div>
              @endforeach
              @else
              <div class="alert alert-info" role="alert">
              Selecciona un médico y una fecha para ver sus horas disponibles
            </div>
              @endif
              </div>
              <div class="form-group">
              <label for= "tipoConsulta">Tipo de Consulta</label>
              <div class= "custom-control custom-radio mb-3">
              <input name= "tipo" class= "custom-control-input"
               id= "tipo1" type= "radio"
               @if(old('tipo', 'Consulta')=='Consulta') checked @endif value="Consulta">
               <label class= "custom-control-label" for= "tipo1">Consulta</label>
              </div>
              <div class= "custom-control custom-radio mb-3">
              <input name= "tipo" class= "custom-control-input"
               id= "tipo2" type= "radio"
               @if(old('tipo')=='Examen') checked @endif value="Examen">
               <label class= "custom-control-label" for= "tipo2">Examen</label>
              </div>
              <div class= "custom-control custom-radio mb-3">
              <input name= "tipo" class= "custom-control-input"
               id= "tipo3" type= "radio"
               @if(old('tipo')=='Operacion') checked @endif value="Operacion">
               <label class= "custom-control-label" for= "tipo3">Operacion</label>
              </div>              
              <button type="submit" class="btn btn-primary">Guardar</button>
              </form>
              </div>           
            </div>
@endsection
@section('scripts')
<script src="{{ asset('vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/citas/create.js') }}"></script>
@endsection