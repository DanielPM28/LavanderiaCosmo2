@extends('layouts.panel')

@section('content')  
      
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Cancelar Reserva</h3>
                </div>
                <div class="col text-right">
                  <a href="{{url('/miscitas')}}" class="btn btn-sm btn-success">
                  <i class="fas fa-chevron-left"></i>
                  Regresar</a>
                </div>
               
              </div>
            </div>
            <div class="card-body">
               @if(session('notification'))
               <div class="alert alert-success" role="alert">
                     {{session('notification')}}
               </div>
               @endif
               @if($role == 'produccion')
               <p>Se cancelara la reserva con el (conductor <b>{{ $appointment->conductor->name }}</b> ) 
               para el día<b> {{ $appointment->scheduled_date }}</b>. </p>
               @elseif($role == 'conductor')
               <p>Se cancelara la reserva de la(produccion <b>{{ $appointment->producers->name }}</b> ) 
               para el día<b> {{ $appointment->scheduled_date }}</b>. </p>
               @else
               <p>Se cancelara la reserva de la(produccion <b>{{ $appointment->producers->name }}</b> ) para el 
               (conductor <b>{{ $appointment->conductor->name }}</b> )
               para el día<b> {{ $appointment->scheduled_date }}, a la hora</b> {{ $appointment->scheduled_time_12 }}. </p>
               @endif
               <form action="{{ url('/miscitas/'.$appointment->id.'/cancel') }}" method="POST">
                 @csrf
                 <div class="form-group">
                      <label for="justification">Ponga los motivos de la cancelacion</label>
                      <textarea name="justification" id="justification"  rows="3" class="form-control" required></textarea>
                 </div>

                 <button class="btn btn-danger" type="submit" >Cancelar cita</button>
               </form>

            </div>
           
         
               
           

          </div>
        
@endsection