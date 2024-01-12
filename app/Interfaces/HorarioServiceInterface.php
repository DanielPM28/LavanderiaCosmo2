<?php  
namespace App\Interfaces;

use Carbon\Carbon;

 interface HorarioServiceInterface {
    public function isAvaliableInterval($date, $driverID, Carbon $start);
    public function getAvailableIntervals($date, $conductorID);
 }