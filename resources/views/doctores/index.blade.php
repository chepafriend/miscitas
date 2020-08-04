@extends('layouts.panel')

@section('content')
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Medicos</h3>
                </div>
                <div class="col text-right">
                  <a href="{{url('doctores/create')}}" class="btn btn-sm btn-primary">Nuevo Medico</a>
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
                    <th scope="col">email</th>
                    <th scope="col">DNI</th>
                    <th scope="col">Opciones</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($doctores as $doctor)
                  <tr>
                    <th scope="row">{{$doctor->nombre}} </th>
                    <td> {{$doctor->email}}  </td>
                    <td> {{$doctor->dni}}  </td>
                    <td> 
                    <form method="POST" action="{{url('doctores/'.$doctor->id)}}">
                    @csrf
                    @method('DELETE')

                  <a  href="{{url('doctores/'.$doctor->id.'/edit')}}" class="btn btn-primary btn-sm">Editar</a> 
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
