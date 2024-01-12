<?php

namespace App\Models;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'scheduled_date',
        'scheduled_time',
        'type',
        'direccion',
        'conductor_id',
        'production_id',
        'producers_id'
    ];

    protected $hidden = [
        'scheduled_time',
        'producers_id',
        'conductor_id'
        
    ];

    protected $appends = [
        'scheduled_time_12'
    ];

    public function producers(){
        return $this->belongsTo(producers::class);
    }
    public function conductor(){
        return $this->belongsTo(User::class);
    }
    public function produccion(){
        return $this->belongsTo(User::class);
    }

    public function getScheduledTime12Attribute(){
        return (new Carbon($this->scheduled_time))
        ->format('g:i A');
    }

    public function cancelation(){
        return $this->hasOne(CancelledAppointment::class);
    }
    static public function createdForProduction(Request $request, $productionId){

        $data = $request->only([
            'scheduled_date',
            'scheduled_time',
            'type',
            'conductor_id',
            'direccion',
            'producers_id'
         ]);
         $data['production_id'] = $productionId;
         
         $carbontime = Carbon::createFromFormat('g:i A', $data['scheduled_time']);
         $data['scheduled_time'] = $carbontime->format('H:i:s');

         return self::create($data);
    }
}
