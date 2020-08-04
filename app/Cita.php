<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Especialidad;
use App\User;
use App\CitaCancelada;

class Cita extends Model
{
    protected $fillable = [
        'descripcion', 'especialidad_id', 'doctor_id','paciente_id', 'fecha_programada','hora_programada', 'tipo'
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
}
