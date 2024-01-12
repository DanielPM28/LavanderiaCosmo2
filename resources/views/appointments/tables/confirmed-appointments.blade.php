<div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Dirección</th>
                    <th scope="col">Productora</th>
                    @if($role == 'produccion')
                    <th scope="col">Conductor</th>
                    @elseif($role == 'conductor')
                    <th scope="col">Produccion</th>
                    @endif
                    <th scope="col">Fecha</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Opciones</th>
                    
                  </tr>
                </thead>
                <tbody>
                  @foreach($confirmerdAppointments as $cita)
                  <tr>
                    <th scope="row">
                      {{$cita->direccion}}
                    </th>
                    <td>
                      {{$cita->producers->name}}
                    </td>
                    @if($role == 'produccion')
                    <td>
                      {{$cita->conductor->name}}
                    </td>
                    @elseif($role == 'conductor')
                    <td>
                      {{$cita->production_id}}
                    </td>
                    @endif
                    <td>
                      {{$cita->scheduled_date}}
                    </td>
                    <td>
                      {{$cita->Scheduled_Time_12}}
                    </td>
                    <td>
                      {{$cita->type}}
                    </td>
                    <td>
                      {{$cita->status}}
                    </td>
                    <td>
                      @if($role == 'admin')
                     <a href="{{ url('/miscitas/'.$cita->id)}}" class="btn btn-sm btn-info" title="Ver cita">
                      Ver
                     </a>
                    @endif
                       
                        <a href="{{ url('/miscitas/'.$cita->id.'/cancel')}}" class="btn btn-sm btn-danger" title="Cancelar cita">
                          Cancelar
                        </a>
                    </td>
                   
                    
                  </tr>
                 @endforeach
                </tbody>
              </table>
            </div>  