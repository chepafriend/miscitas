<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Especialidad;
use App\User;
use App\CitaCancelada;

class Cita extends Model
{
    protected $fillable = [
        'descripcion', 'especialidad_id', 'doctor_id','paciente_id', 'fecha_programada','hora_programada', 'tipo'
    ];

    protected $hidden = [
        'especialidad_id', 'doctor_id','hora_programada'
    ];

    protected $appends = [
        'hora_programada_12'
    ];

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);

    }
    public function doctor()
    {
        return $this->belongsTo(User::class);

    }
    public function paciente()
    {
        return $this->belongsTo(User::class);

    }
    public function cancelacion(){
        return $this->hasOne(CitaCancelada::class);
    }
    public function getHoraProgramada12Attribute(){
        return (new Carbon($this->hora_programada))->format('g:i A');
    }

    static public function creadoPorPaciente(Request $request, $pacienteId){
       
        $data = $request->only([
            'descripcion',
            'especialidad_id',
            'doctor_id',
            'fecha_programada',
            'hora_programada', 
            'tipo']); 
            
            $data['paciente_id']=$pacienteId;

            $carbonHora = Carbon::createFromFormat('g:i A', $data['hora_programada']);
            $data['hora_programada']=$carbonHora->format('H:i:s');

           return self::create($data);
    }
}
