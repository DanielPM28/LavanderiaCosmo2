<?php

namespace App\Http\Controllers;

use App\Http\Controllers\admin\ProducersController;
use App\Http\Requests\StoreAppointment;
use App\Interfaces\HorarioServiceInterface;
use App\Models\Appointment;
use App\Models\CancelledAppointment;
use Illuminate\Http\Request;
use App\Models\producers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{



    public function index(){
 
        
        $role = auth()->user()->role;

        if ($role == 'admin') {
            $confirmerdAppointments = Appointment::all()
        ->where('status', 'Confirmada');
        
        $pendingAppointments = Appointment::all()
        ->where('status', 'Reservada');
        
        $oldAppointments = Appointment::all()
        ->whereIn('status', ['Completada', 'Cancelada']);
        

        }
        elseif($role == 'conductor'){
            //Conductores
        $confirmerdAppointments = Appointment::all()
        ->where('status', 'Confirmada')
        ->where('conductor_id', auth()->id() );
        $pendingAppointments = Appointment::all()
        ->where('status', 'Reservada')
        ->where('conductor_id', auth()->id() );
        $oldAppointments = Appointment::all()
        ->whereIn('status', ['Completada', 'Cancelada'])
        ->where('conductor_id', auth()->id() );

        }elseif($role == 'produccion'){
          //Producciones
        $confirmerdAppointments = Appointment::all()
        ->where('status', 'Confirmada')
        ->where('production_id', auth()->id());
        $pendingAppointments = Appointment::all()
        ->where('status', 'Reservada')
        ->where('production_id', auth()->id());
        $oldAppointments = Appointment::all()
        ->whereIn('status', ['Completada', 'Cancelada'])
        ->where('production_id', auth()->id());
        }

        return view('appointments.index',
         compact('confirmerdAppointments','pendingAppointments','oldAppointments','role') );
    }

    public function create(HorarioServiceInterface $horarioServiceInterface){
        $producer =  producers::all();
        $producerId = old('producer_id');

        if($producerId){
             $produc = producers::find($producerId);
             $conductor = $produc->users;
        }else {
            $conductor = collect();
        }
      
        $date = old('schedule_date');
        $DriverID = old('conductor_id');
        $productionId =old('production_id');

        if ($date && $DriverID) {
            $intervals = $horarioServiceInterface->getAvailableIntervals($date,$DriverID);
        }else{
            $intervals = null;
        }

        return view('appointments.create', compact('producer','conductor','intervals'));
        
    }

    public function store(StoreAppointment $request, HorarioServiceInterface $horarioServiceInterface){

          $created = Appointment::createdForProduction($request, auth()->id());

          if ($created) {
            $notification = 'La reserva se ha registrado correctamente.';
          }else {
            $notification = 'Error al registrar la reserva.';
          }

         return redirect('/miscitas')->with(compact('notification'));
    }

    public function cancel(Appointment $appointment, Request $request){


        if ($request->has('justification')) {
            $cancellation = new CancelledAppointment();
            $cancellation->justification = $request->input('justification');
            $cancellation->cancelled_by_id = auth()->id();

            $saved = $appointment->cancelation()->save($cancellation);
            $nameConductor = $appointment->conductor->name;
            $dateAppointment = $appointment->scheduled_date;
            $timeAppointment = $appointment->scheduled_time_12;
            if ($saved) {
                $appointment->production->sendFCM("Su reserva con el conductor: $nameConductor, para la fecha: $dateAppointment, a las $timeAppointment fue cancelada");
            }
        }

        $appointment->status = 'Cancelada';
        $appointment->save();
        $notification = 'La reserva se ha cancelado correctamente.';

       return redirect('/miscitas')->with(compact('notification'));
    }

    public function formCancel(Appointment $appointment){
        if ($appointment->status == 'Confirmada') {
            $role = auth()->user()->role;
            return view('appointments.cancel', compact('appointment','role'));
        }
        return  redirect('/miscitas');
    }
    public function show(Appointment $appointment){
        $role = auth()->user()->role;
         return view('appointments.show', compact('appointment','role') );
    }

    public function confirm(Appointment $appointment){
        

        $appointment->status = 'Confirmada';
        $saved = $appointment->save();
        if ($saved) {
            $appointment->production->sendFCM('Su reserva fue confirmada');
        }
        $notification = 'La reserva se ha confirmado correctamente.';

       return redirect('/miscitas')->with(compact('notification'));
    }
}
