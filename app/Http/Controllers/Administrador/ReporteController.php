<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cita;
use App\User;
use Carbon\Carbon;
use DB;

class ReporteController extends Controller
{

    public function citas(){
        $cantidadesMensuales= Cita::select(
            DB::raw('MONTH(created_at) as  mes'),
            DB::raw('COUNT(1) as cantidad'))
            ->groupby('mes')->get()->toArray();

            $cantidades= array_fill(0,12,0);
        foreach($cantidadesMensuales as $cantidadMensual){
            $index= $cantidadMensual['mes'] - 1;
            $cantidades[$index]= $cantidadMensual['cantidad'];
        }
        
       return view('reportes.citas', compact('cantidades'));
    }

    public function doctores(){

        $ahora= Carbon::now();
        $fin= $ahora->format('Y-m-d');
        $inicio= $ahora->subYear()->format('Y-m-d');
        

        return view('reportes.doctores', compact('inicio', 'fin'));
    }

    public function doctoresJson(Request $request){

        $inicio=$request->input('inicio');
        $fin=$request->input('fin');

        $doctores= User::doctores()
                    ->select('nombre')
                    ->withCount([
                        'CitasAtendidas'=>function($query) use ($inicio, $fin){
                        $query->whereBetween('fecha_programada', [$inicio, $fin]);
                    },
                        'CitasCanceladas'=>function($query) use ($inicio, $fin){
                        $query->whereBetween('fecha_programada', [$inicio, $fin]);
                        }
                    ])
                    ->orderBy('citas_atendidas_count', 'desc')
                    ->take(3)->get();

                    $data= [];
                    $data['categorias'] = $doctores->pluck('nombre');

                    $series1['name']= 'citas atendidas';
                    $series1['data']= $doctores->pluck('citas_atendidas_count');

                    $series2['name']= 'citas canceladas';
                    $series2['data']= $doctores->pluck('citas_canceladas_count');

                    $series[]= $series1;
                    $series[]= $series2;

                    $data['series']= $series;

        return $data;
    }
    //
}
