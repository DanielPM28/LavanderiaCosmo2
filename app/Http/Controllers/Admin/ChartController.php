<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function appointments(){

        $monthCounts = Appointment::select(
           DB::raw('MONTH(created_at) as month'),
           DB::raw('COUNT(1) as count'))
            ->groupBy('month')
            ->get()
            ->toArray();

            $counts = array_fill(0, 12, 0);
            
            foreach($monthCounts as $monthCount){
                $index = $monthCount['month']-1;
                $counts[$index] = $monthCount['count'];
            }

        return view('charts.appointments', compact('counts'));
    }

    public function drivers(){
        $now = Carbon::now();
        $end = $now->format('Y-m-d');
        $start = $now->subYear()->format('Y-m-d');
       return view('charts.drivers', compact('end','start'));
    }
    public function driversJson(Request $request){

        $start = $request->input('start');
        $end = $request->input('end');
        
        $drivers =  User::conductores()
         ->select('name')
         ->withCount(['attendedAppointments' => function($query) use ($start, $end){
            $query->whereBetween('scheduled_date', [$start,$end]);
         },'cancelledAppointments'=> function($query) use ($start, $end){
            $query->whereBetween('scheduled_date', [$start,$end]);
         }])
         ->get();
        
        $data = [];
        $data['categories'] = $drivers->pluck('name');

        $series = [];
        $series1['name'] = 'Reservas atendidas';
        $series1['data'] = $drivers->pluck('attended_appointments_count');
        $series2['name'] = 'Reservas canceladas';
        $series2['data'] = $drivers->pluck('cancelled_appointments_count');

        $series[] = $series1;
        $series[] = $series2;
        $data['series'] = $series;

        return $data;

    }
}
