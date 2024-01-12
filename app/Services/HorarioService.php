<?php namespace App\Services;

use App\Interfaces\HorarioServiceInterface;
use App\Models\Appointment;
use App\Models\Horarios;
use Carbon\Carbon;

class HorarioService implements HorarioServiceInterface {

    private function getDayFromDate($date){
       $dateCarbon = new Carbon($date);
       $i = $dateCarbon->dayOfWeek;
       $day = ($i == 0 ? 6 : $i-1);
       return $day;
    }

    public function isAvaliableInterval($date, $driverID, Carbon $start){
        $exists = Appointment::where('conductor_id', $driverID)
        ->where('scheduled_date', $date)
        ->where('scheduled_time', $start->format('H:i:s'))
        ->exists();

        return !$exists;
    }

    public function getAvailableIntervals($date, $driverID){
        $horario = Horarios::where('active', true)
       ->where('day', $this->getDayFromDate($date))
       ->where('user_id', $driverID)
       ->first([
        'morning_start',
        'morning_end',
        'afternoon_start',
        'afternoon_end'
       ]);
       if($horario){
        $morningintervalos = $this->getIntervalos(
            $horario->morning_start, $horario->morning_end ,$driverID, $date
        );
           $afternoonintervalos = $this->getIntervalos(
            $horario->afternoon_start, $horario->afternoon_end ,$driverID, $date
        );
       }else{
        $morningintervalos = [];
        $afternoonintervalos = [];
       }

     
        $data = [];
        $data['morning'] = $morningintervalos;
        $data['afternoon'] = $afternoonintervalos;
        return $data;
    }

    private function getIntervalos($start, $end, $driverID, $date){
        $start = new Carbon($start);
        $end = new Carbon($end);
 
        $intervalos = [];
        while ($start < $end){
          $inter = [];
          $inter['start'] = $start->format('g:i A');
          $avaliable = $this->isAvaliableInterval($date, $driverID, $start);
          $start->addMinutes(30);
          $inter['end'] = $start->format('g:i A');
          if($avaliable){
            $intervalos [] = $inter;
          }
          
        }
        return $intervalos;
     }
}