<?php 
namespace App\Interfaces;
use Carbon\Carbon;

interface HorarioServiceInterface{

    public function getIntervalosDisponibles($fecha, $doctorId);
    public function esIntervaloDisponible($fecha, $doctorId, Carbon $inicio);
}