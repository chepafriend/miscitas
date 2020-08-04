<div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Especialidad</th>                    
                    <th scope="col">Fecha</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Opciones</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($citasAntiguas as $cita)
                  <tr>
                    <td> {{$cita->especialidad->nombre}}  </td>
                    <td> {{$cita->fecha_programada}}  </td>
                    <td> {{$cita->hora_programada_12}}  </td>
                    <td> {{$cita->estado}}  </td>
                    <td> <a href= "{{ url('/citas/'.$cita->id)}}" 
                    class= "btn btn-primary btn-sm">Ver</a></td>                       
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <div class="card-body">
            {{ $citasAntiguas->links()}}
            </div>