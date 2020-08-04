@extends('layouts.panel')

@section('content')
    <form method="POST" action="{{url('/horarios')}}">
    @csrf
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Gestionar Horario</h3>
                </div>
                <div class="col text-right">
                  <button type="submit" class="btn btn-sm btn-primary">Guardar cambios</button>
                </div>
              </div>
            </div>
            <div class="card-body">
            @if (session('notificacion'))
            <div class="alert alert-success" role="alert">
            {{session('notificacion')}}
            </div>
            @endif
            @if (session('errors'))
            <div class="alert alert-danger" role="alert">
            Los cambios se han guardado pero tener en cuenta lo siguiente:
            <ul>
            @foreach(session('errors') as $error)
            <li> {{ $error}}</li>
            @endforeach
            </ul>
            </div>
            @endif
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Dia</th>
                    <th scope="col">Activo</th>
                    <th scope="col">Turno Mañana </th>
                    <th scope="col">Turno Tarde</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($diasLaborables as $clave=>$diaLaborable)
                <tr>
                <th> Dia {{$dias[$clave]}} </th>
                <td> 
                <label class="custom-toggle">
                    <input type="checkbox" name="activo[]" value="{{$clave}}"
                    @if  ($diaLaborable->activo) checked @endif>
                    <span class="custom-toggle-slider rounded-circle"></span>
                </label>
                </td>
                <td>
                <div class="row">
                    <div class="col">
                    <select class="form-control" name="inicio_manana[]">                
                    @foreach($manana_horas as $hora)
                          <option value="{{ $hora['valor'] }}" @if($hora['dato'].' AM' == $diaLaborable->inicio_manana) selected @endif> {{ $hora['valor'] }} AM </option>
                        @endforeach                  
                    </select>
                    </div>
                    <div class="col">
                    <select class="form-control" name="fin_manana[]">
                    @foreach($manana_horas as $hora)
                          <option value="{{ $hora['valor'] }}" @if($hora['dato'].' AM' == $diaLaborable->fin_manana) selected @endif> {{ $hora['valor'] }} AM </option>
                        @endforeach  
                    </select>
                    </div>                    
                </div>    
                </td>
                <td>
                <div class="row">
                    <div class="col">
                    <select class="form-control" name="inicio_tarde[]">
                    @foreach($tarde_horas as $hora)
                          <option value="{{ $hora['valor'] }}" @if($hora['dato'].' PM' == $diaLaborable->inicio_tarde) selected @endif> {{ $hora['valor'] }} PM </option>
                        @endforeach  
                    </select>
                    </div>
                    <div class="col">
                    <select class="form-control" name="fin_tarde[]">
                    @foreach($tarde_horas as $hora)
                          <option value="{{ $hora['valor'] }}" @if($hora['dato'].' PM' == $diaLaborable->fin_tarde) selected @endif> {{ $hora['valor'] }} PM </option>
                        @endforeach 
                    </select>
                    </div>                    
                </div> 
                </td>
                </tr>
                @endforeach              
                </tbody>
              </table>
            </div>
            </div>
    </form>
@endsection
