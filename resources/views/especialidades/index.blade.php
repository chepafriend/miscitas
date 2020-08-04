@extends('layouts.panel')

@section('content')
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Especialidades</h3>
                </div>
                <div class="col text-right">
                  <a href="{{route('create')}}" class="btn btn-sm btn-primary">Nueva Especialidad</a>
                </div>
              </div>
            </div>

            <div class="card-body">
            @if (session('notificacion'))
            <div class="alert alert-success" role="alert">
            {{session('notificacion')}}
            </div>
            @endif
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Opciones</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($especialidades as $especialidad)
                  <tr>
                    <th scope="row">{{$especialidad->nombre}} </th>
                    <td> {{$especialidad->descripcion}}  </td>
                    <td> 
                    <form method="POST" action="{{route('destroy',['especialidad' => $especialidad->id])}}">
                    @csrf
                    @method('DELETE')
                  <a  href="{{route('edit', ['especialidad' => $especialidad->id])}}" class="btn btn-primary btn-sm">Editar</a> 
                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                     </td>                    
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            </div>

@endsection
