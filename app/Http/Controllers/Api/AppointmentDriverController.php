<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointment;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AppointmentDriverController extends Controller
{
    public function index(){
        $user = Auth::guard('api')->user();
        $appointments = $user->asDriverAppointments()
        ->with([
            'producers'=>function($query){
                $query->select('id','name');
            },
            'produccion' =>function($query){
                $query->select('id');
            }
        ])
        ->get([
            "id",
            "scheduled_date",
            "scheduled_time",
            "type",
            "direccion",
            "production_id",
            "producers_id",
            "created_at",
            "status"
        ]);
        
        return $appointments;
    }
    
    
   
}
