<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Interfaces\HorarioServiceInterface;
use Carbon\Carbon;

class StoreCita extends FormRequest
{
    private $horarioService;

    public function __construct(HorarioServiceInterface $horarioService){
        $this->horarioService = $horarioService;
    }

    /**
         * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'descripcion'=>'required',
            'especialidad_id'=>'exists:especialidads,id',
            'doctor_id'=>'exists:users,id',
            'hora_programada'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'hora_programada.required'=>"Seleccione una hora valida para su cita.",
        ];
    }

    public function withValidator($validacion)
    {
        $validacion->after(function($validacion) {

            $fecha = $this->input('fecha_programada');
            $doctorId = $this->input('doctor_id');
            $hora_programada = $this->input('hora_programada');
    
            if($fecha && $doctorId && $hora_programada){
                $inicio = new Carbon($hora_programada);
            } else {
                return;
            }
    
            if(!$this->horarioService->esIntervaloDisponible($fecha, $doctorId, $inicio)){
    
                $validacion->errors()
                    ->add('hora_disponible', 'La hora seleccionada se encuentra reservada para otro paciente.');
                }
            });
    }
}
