@extends('layouts.panel')

@section('content')
<div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Bienvenido! Por favor selecciona una opción del menu lateral izquierdo.
                </div>
            </div>
        </div>
        @if(auth()->user()->rol == 'administrador')
        <div class="col-xl-6 mb-5 mb-xl-0">
          <div class="card shadow">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-uppercase ls-1 mb-1">Notificación General</h6>
                  <h2 class="mb-0">Enviar a todos los usuarios</h2>
                </div>                
              </div>
            </div>
            <div class="card-body">
               @if (session('notificacion'))
                <div class="alert alert-success" role="alert">
                  {{session('notificacion')}}
                  </div>
                @endif
              <form action="{{url('/fcm/send')}}" method="post">
              @csrf
              <div class="form-group">
              <label for="title">Título</label>
              <input type="text" class="form-control" name="title" id="title" required>
              </div>
              <div class="form-group">
              <label for="body">Mensaje</label>
              <textarea rows="3" class="form-control" name="body" id="body" required></textarea>
              </div>
                <button class="btn btn-primary">Enviar Notificación</button>
              </form>              
            </div>
          </div>
        </div>
        <div class="col-xl-6">
          <div cls="card shadow">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-uppercase text-muted ls-1 mb-1">Total de Citas</h6>
                  <h2 class="mb-0">Según dia de la semana</h2>
                </div>
              </div>
            </div>
            <div class="card-body">
              <!-- Chart -->
              <div class="chart">
                <canvas id="chart-orders" class="chart-canvas"></canvas>
              </div>
            </div>
          </div>
        </div>
        @endif
</div>       
@endsection

@section('scripts')
<script> const citasPorDia= @json($citasPorDia); </script>
<script src="{{ asset('js/reportes/home.js?v=1.0.0') }}"></script>
@endsection
