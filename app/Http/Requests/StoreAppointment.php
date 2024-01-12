<?php

namespace App\Http\Requests;

use App\Interfaces\HorarioServiceInterface;
use App\Services\HorarioService;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class StoreAppointment extends FormRequest
{
    private $horarioService;

    public function __construct(HorarioServiceInterface $horarioServiceInterface){
          $this->horarioService = $horarioServiceInterface;
    }   
    
  
    public function rules(): array
    {
        return [
            'scheduled_time'=>'required',
            'type' => 'required',
            'direccion' =>'required',
            'conductor_id' => 'exists:users,id',
            'producers_id' => 'exists:producers,id',
            
        ];
    }
    public function messages()
{
    return [
        'scheduled_time.required' =>'Debes seleccionar una hora.',
        'type.required' => 'Debe seleccionar un tipo de servicio.',
        'direccion.required' => 'Debe escribir la dirrección.'
    ];
}
public function withValidator($validator)
{
    $validator->after(function ($validator) {
            $date = $this->input('scheduled_date');
            $DriverID = $this->input('conductor_id');
            $scheduled_time = $this->input('scheduled_time');

            if ($date && $DriverID && $scheduled_time) {
                $start = new Carbon($scheduled_time);
            }else{
                return ;
            }

            if (!$this->horarioService->isAvaliableInterval($date, $DriverID, $start)) {
                $validator->errors()->add(
                    'avaliable_time', 'La hora seleccionada ya se encuentra ocupada'
                );
            }
    });
}
}
