<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cita;
use DB;
use Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $minutes= 1440;
        $citasPorDia=  Cache::remember('citas_por_dia', $minutes, function(){
            $resultados= Cita::select([
            DB::raw('DAYOFWEEK(fecha_programada) as dia'),
            DB::raw('COUNT(*) as count')
            ])->groupBy('dia')->where('estado', 'Confirmada')
            ->get(['dia', 'count'])
            ->mapWithKeys(function($item){
                return[$item['dia']=>$item['count']];
            })->toArray();

            $conteo= [];
            for($i=1; $i<=7; ++$i){
                if(array_key_exists($i, $resultados))
                $conteo[]= $resultados[$i];
                else
                $conteo[]= 0;
            }

            return $conteo;
        });
        
        return view('home', compact('citasPorDia'));
    }
}
