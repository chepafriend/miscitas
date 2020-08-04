<?php
namespace App\Services;

use  App\Interfaces\HorarioServiceInterface;
use  App\Dialaborable;
use App\Cita;
use Carbon\Carbon;

class HorarioService implements HorarioServiceInterface
{

    public function esIntervaloDisponible($fecha, $doctorId, Carbon $inicio)
    {
      $disponible = Cita::where('doctor_id', $doctorId)
                          ->where('fecha_programada', $fecha)
                          ->where('hora_programada', $inicio->format('H:i:s'))
                          ->where('estado', '!=' , 'Cancelada')
                          ->exists();

        return !$disponible;

    }
    private function getDiadeFecha($fecha)
    {
        $fechaCarbon = new Carbon($fecha);
        $i = $fechaCarbon->dayOfWeek;
                $dia = ($i==0 ? 6 : $i-1);

       return $dia;
    }
    public function getIntervalosDisponibles($fecha, $doctorId){

        $diaLaborable = Dialaborable::where('activo',true)
        ->where('dia', $this->getDiadeFecha($fecha))
        ->where('user_id', $doctorId)
        ->first(['inicio_manana', 'fin_manana',
                'inicio_tarde', 'fin_tarde']);
    
    if(!$diaLaborable){
    return [];
    }
    $intervalosManana = $this->getIntervalos($diaLaborable->inicio_manana, $diaLaborable->fin_manana, $fecha, $doctorId);
    $intervalosTarde = $this->getIntervalos($diaLaborable->inicio_tarde, $diaLaborable->fin_tarde, $fecha, $doctorId);
    
    $data = [];
    $data['manana'] = $intervalosManana;
    $data['tarde'] = $intervalosTarde;
    return $data;
    
    }
    
    private function getIntervalos($inicio, $fin, $fecha, $doctorId)
    { 
      
      $inicio = new Carbon($inicio);
      $fin = new Carbon($fin);
      $intervalos = [];
    
      while($inicio<$fin){
      $intervalo = [];
      $intervalo['inicio'] = $inicio->format('g:i A');
      $disponible = $this->esIntervaloDisponible($fecha, $doctorId, $inicio);
      $inicio->addMinutes(30);
      $intervalo['fin'] = $inicio->format('g:i A');

      if($disponible)  {
      $intervalos[] = $intervalo;
    }
    }
    return $intervalos;
    }
    
}