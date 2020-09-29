@extends('layouts.panel')

@section('content')
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Modificar datos de usuario</h3>
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
            <form method="POST" action="{{url('perfil')}}">
              @csrf
              <div class="form-group">
              <label for= "nombre">Nombre Completo</label>
              <input name="nombre" id="nombre"
              class= "form-control" type= "text" value="{{old('nombre', $user->nombre)}}"
              required>              
              </div>
              <div class="form-group">
              <label for= "telefono">Número de Telefono</label>
              <input name="telefono" id="telefono"
              class= "form-control" type= "text" value="{{old('telefono', $user->telefono)}}"
              required>              
              </div>
              <div class="form-group">
              <label for= "direccion">Dirección</label>
              <input name="direccion" id="direccion"
              class= "form-control" type= "text" value="{{old('direccion', $user->direccion)}}"
              required>              
              </div>
                           
              <button type="submit" class="btn btn-primary">Guardar Cambios</button>
              </form>
              </div>           
            </div>
@endsection
