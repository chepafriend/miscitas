<div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Descripción</th>
                    <th scope="col">Especialidad</th>
                    @if($rol == 'paciente')
                    <th scope="col">Médico</th>
                    @elseif($rol == 'doctor')
                    <th scope="col">Paciente</th>
                    @endif 
                    <th scope="col">Fecha</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Opciones</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($citasPendientes as $cita)
                  <tr>
                    <td> {{$cita->descripcion}}  </td>
                    <td> {{$cita->especialidad->nombre}}  </td>
                    @if($rol == 'paciente')
                    <td> {{$cita->doctor->nombre}}  </td>
                    @elseif($rol == 'doctor')
                    <td> {{$cita->paciente->nombre}}  </td>
                    @endif 
                    <td> {{$cita->fecha_programada}}  </td>
                    <td> {{$cita->hora_programada_12}}  </td>
                    <td> {{$cita->tipo}}  </td>
                    <td>

                    @if($rol == 'administrador')                                     
                    <a class="btn btn-primary btn-sm" title="Ver cita"
                    href="{{url('/citas/'.$cita->id)}}" data-toggle = "tooltip">Ver</a>                   
                    @endif  

                    @if($rol == 'doctor'|| $rol == 'administrador') 
                    <form  action="{{ url('/citas/'.$cita->id.'/confirm') }}" method="POST" class= "d-inline-block">
                    @csrf
                    
                    <button type="submit" title= "Confirmar Cita" class= "btn btn-success btn-sm" data-toggle = "tooltip">
                    <i class= "ni ni-check-bold"></i></button>
                    @endif 

                    @if($rol == 'doctor'|| $rol == 'administrador')
                    <a  href="{{ url('/citas/'.$cita->id.'/cancel') }}" title= "Cancelar Cita" class= "btn btn-danger btn-sm" data-toggle = "tooltip">
                   <i class= "ni ni-fat-delete"></i>
                    @else 
                    <form  action="{{ url('/citas/'.$cita->id.'/cancel') }}" method="POST" class= "d-inline-block">
                    @csrf
                  
                    <button type="submit" title= "Cancelar Cita" class= "btn btn-danger btn-sm" data-toggle = "tooltip">
                    <i class= "ni ni-fat-delete"></i></button>
                    </form>
                    @endif 
                     </td>                    
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <div class="card-body">
            {{ $citasPendientes->links()}}
            </div>