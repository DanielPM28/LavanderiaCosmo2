@extends('layouts.panel')

@section('content')  
      
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Reserva #{{ $appointment->id }}</h3>
                </div>
                <div class="col text-right">
                  <a href="{{url('/miscitas')}}" class="btn btn-sm btn-success">
                  <i class="fas fa-chevron-left"></i>
                  Regresar</a>
                </div>
               
              </div>
            </div>
            <div class="card-body">
              <ul>
                <dd>
                    <strong>Fecha:</strong> {{ $appointment->schedule_date }}
                </dd>
                <dd>
                    <strong>Hora:</strong> {{ $appointment->schedule_time_12 }}
                </dd>
                @if($role == 'produccion' || 'admin')
                <dd>
                    <strong>Conductor:</strong> {{ $appointment->conductor->name}}
                </dd>
                @elseif($role == 'conductor' || 'admin')
                <dd>
                    <strong>Producción:</strong> {{ $appointment->produccion->name}}
                </dd>
                @endif
                <dd>
                    <strong>Producción:</strong> {{ $appointment->producers->name}}
                </dd>
                <dd>
                    <strong>Tipo de reserva:</strong> {{ $appointment->type}}
                </dd>
                <dd>
                    <strong>Estado:</strong> 
                    @if($appointment->status == 'Cancelada')
                    <span class="badge badge-danger">Cancelada</span>
                    @else
                    <span class="badge badge-primary">{{ $appointment->status }}</span>
                    @endif
                </dd>
                <dd>
                    <strong>Dirección:</strong> {{ $appointment->direccion}}
                </dd>
                
              </ul>
              @if($appointment->status == 'Cancelada')
              <div class="alert bg-light text-primary">
                 <h3>Detalles de la cancelación</h3>
                 @if($appointment->cancellation)
                     <ul>
                        <li>
                            <strong>Fecha Cancelación:</strong>
                            {{ $appointment->cancellation->create_at }}
                        </li>
                        <li>
                            <strong>La reserva se cancelo por:</strong>
                            {{ $appointment->cancellation->cancelled_by->name}}
                        </li>
                        <li>
                            <strong>Motivo:</strong>
                            {{ $appointment->cancellation->justification}}
                        </li>
                     </ul>
                     @else
                     <ul>
                        <li>La reserva fuer cancelada antes de su confirmación.</li>
                     </ul>
                 @endif
              </div>
                 @endif
            </div>
           
         
               
           

          </div>
        
@endsection