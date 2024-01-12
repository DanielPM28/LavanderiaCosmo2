<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointment;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index(){
        $user = Auth::guard('api')->user();
        $appointments = $user->asProductionsAppointments()
        ->with([
            'producers'=>function($query){
                $query->select('id','name');
            },
            'conductor' =>function($query){
                $query->select('id','name');
            }
        ])
        ->get([
            "id",
            "scheduled_date",
            "scheduled_time",
            "type",
            "direccion",
            "conductor_id",
            "producers_id",
            "created_at",
            "status"
        ]);
        return $appointments;
    }
    public function store(StoreAppointment $request){
        $productionId = Auth::guard('api')->id();
        $appointment = Appointment::createdForProduction($request, $productionId);

        if ($appointment) {
            $success = true;
        }else {
            $success = false;
        }
        return compact('success');
    }
    
}
