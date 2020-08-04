@extends('layouts.panel')

@section('content')
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Citas</h3>
                </div>
                
              </div>
            </div>

            <div class="card-body">
            @if (session('notificacion'))
            <div class="alert alert-success" role="alert">
            {{session('notificacion')}}
            </div>
            @endif 
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
            <a class="nav-link active"  data-toggle="pill" href="#citas_confirmadas" role="tab"  aria-selected="true">Mis proximas citas</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" data-toggle="pill" href="#citas_pendientes" role="tab"  aria-selected="false">Citas por confirmar</a>
            </li>
            <li class="nav-item">
            <a class="nav-link"  data-toggle="pill" href="#citas_antiguas" role="tab" aria-selected="false">Historial de citas</a>
            </li>
            </ul>                     
            </div>
            <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="citas_confirmadas" role="tabpanel">
            @include('citas.tablas.confirmadas')
            </div>
            <div class="tab-pane fade" id="citas_pendientes" role="tabpanel" >
            @include('citas.tablas.pendientes')
            </div>
            <div class="tab-pane fade" id="citas_antiguas" role="tabpanel" >
            @include('citas.tablas.antiguas')
            </div>
            </div>           
            </div>  
@endsection
