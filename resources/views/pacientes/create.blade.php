@extends('layouts.panel')

@section('content')
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Nuevo Paciente</h3>
                </div>
                <div class="col text-right">
                  <a href="{{url('pacientes')}}" class="btn btn-sm btn-default">Cancelar y volver</a>
                </div>
              </div>
            </div>
            <div class="card-body"> 
            @if($errors->any())
            <div class="alert alert-danger" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
            </div>
            @endif           
            <form method="POST" action="{{url('pacientes')}}">
              @csrf
              <div class="form-group">
              <label for= "nombre"> Nombre de Paciente</label>
              <input type="text" name="nombre" class="form-control" value= "{{old('nombre')}}" required>
              </div> 
              <div class="form-group">
              <label for= "email">email</label>
              <input type="text" name="email" class="form-control"value= "{{old('email')}}" >
              </div>
              <div class="form-group">
              <label for= "dni">DNI</label>
              <input type="dni" name="dni" class="form-control"value= "{{old('dni')}}" >
              </div> 
              <div class="form-group">
              <label for= "direccion">Direccion</label>
              <input type="text" name="direccion" class="form-control"value= "{{old('direccion')}}" >
              </div>
              <div class="form-group">
              <label for= "telefono">Telefono/Movil</label>
              <input type="text" name="telefono" class="form-control"value= "{{old('telefono')}}" >
              </div>
              <div class="form-group">
              <label for= "password">Contraseña</label>
              <input type="text" name="password" class="form-control" value= "{{ str_random(6) }}" >
              </div>
              <button type="submit" class="btn btn-primary">Guardar</button>
              </form>
              </div>           
            </div>
@endsection