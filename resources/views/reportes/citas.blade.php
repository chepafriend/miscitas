@extends('layouts.panel')

@section('content')
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Reporte: Frecuencia de citas</h3>
                </div>
              </div>
            </div>

            <div class="card-body">
            <div id="container" data-user=@json($cantidades)>
            
            </div>
         
            </div>
        
        </div>

@endsection

@section('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="{{asset('js/reportes/citas.js')}}"></script>
@endsection
