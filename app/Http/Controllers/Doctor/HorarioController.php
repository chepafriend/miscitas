<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Dialaborable;
use Carbon\Carbon;

class HorarioController extends Controller
{
    private $dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
    
    private function generarHoras($desde, $hasta, $manana = null){
        $horas = [];
        for($i = $desde; $i <= $hasta; $i++){
           
           if ($manana){
               $horas [] = array(
                            'valor' => ($i < 10 ? '0' : '') . $i . ':00',
                            'dato' => $i . ':00'
                        ); 
               $horas [] = array(
                            'valor' => ($i < 10 ? '0' : '') . $i . ':30',
                            'dato' => $i . ':30'
                        ); 
            }
            else {
              $horas [] = array(
                            'valor' => ($i+12) . ':00',
                            'dato' => $i . ':00'
                        ); 
              $horas [] = array(
                            'valor' => ($i+12) . ':30',
                            'dato' => $i . ':30'
                        ); 
           }
        } 
        return $horas;
    }

   public function edit()
    {            
        $diasLaborables = DiaLaborable::where('user_id', auth()->id())->get();
        if(count($diasLaborables) > 0){

            $diasLaborables->map( function($diaLaborable){
            $diaLaborable->inicio_manana = (new Carbon($diaLaborable->inicio_manana))->format('g:i A');
            $diaLaborable->fin_manana = (new Carbon($diaLaborable->fin_manana))->format('g:i A');
            $diaLaborable->inicio_tarde = (new Carbon($diaLaborable->inicio_tarde))->format('g:i A');
            $diaLaborable->fin_tarde = (new Carbon($diaLaborable->fin_tarde))->format('g:i A');

            return $diaLaborable;
        });
        } else {
            $diasLaborables = collect();
            for($i=0; $i<7; ++$i)
                $diasLaborables->push(new Dialaborable());
        }


        //dd($diasLaborables->toArray());        
        $dias = $this->dias;
        $manana_horas = $this->generarHoras(5, 11, true);
        $tarde_horas = $this->generarHoras(1, 11);
        //dd($manana_horas);
        return view('horarios', compact('diasLaborables', 'dias', 'manana_horas', 'tarde_horas'));
    }

    public function store(Request $request)
    {
        $activo = $request->input('activo')?: [];
        $inicio_manana = $request->input('inicio_manana');
        $fin_manana = $request->input('fin_manana');
        $inicio_tarde = $request->input('inicio_tarde');
        $fin_tarde = $request->input('fin_tarde');

        $errors =[];
        for($i=0; $i<7; ++$i){

        if($inicio_manana[$i] > $fin_manana[$i]){
            $errors[] = 'Las horas del turno mañana son inconsistentes para el dia '.$this->dias[$i];
        }
        if($inicio_tarde[$i] > $fin_tarde[$i]){
            $errors[] = 'Las horas del turno tarde son inconsistentes para el dia '.$this->dias[$i];
        }
        Dialaborable::updateOrCreate(
        [
            'dia' => $i,
            'user_id' => auth()->id()
        ],
        [
            'activo' => in_array($i, $activo),
            'inicio_manana' => $inicio_manana[$i],
            'fin_manana' => $fin_manana[$i],

            'inicio_tarde' => $inicio_tarde[$i],
            'fin_tarde' => $fin_tarde[$i]
        ]
        );
    }
            if(count($errors) >0)
                return back()->with(compact('errors')); 
            $notificacion = 'Los cambios se han guardado correctamente.';
            return back()->with(compact('notificacion'));   
    }
}
