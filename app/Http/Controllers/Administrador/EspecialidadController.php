<?php

namespace App\Http\Controllers\Administrador;

use Illuminate\Http\Request;
use App\Especialidad;
use App\Http\Controllers\Controller;

class EspecialidadController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    private  function performValidation(Request $request){
        $rules=[
            'nombre'=>'required|min:3'
        ];
        $messages=[
            'nombre.required'=>"Es necesario ingresar un nombre.",
            'nombre.min'=>"Como mínimo el nombre debe tener 3 caracteres.",
        ];
        $this->validate($request, $rules, $messages);

    }
    public function index(){
        $especialidades = Especialidad::all();
        return view('especialidades.index', compact('especialidades'));
    }
    public function create(){
        return view('especialidades.create');
    }
    public function store(Request $request){

        $this->performValidation($request);
        $especialidad = new Especialidad();
        $especialidad->nombre = $request->input('nombre');
        $especialidad->descripcion = $request->input('descripcion');
        $especialidad->save();

        $notificacion = 'La especialidad se ha creado correctamente';
        return redirect('especialidades')->with(compact('notificacion'));
    }
    public function edit(Especialidad $especialidad){
        return view('especialidades.edit', compact('especialidad'));
    }   

    public function update(Request $request, Especialidad $especialidad){

        $this->performValidation($request);

       $especialidad->nombre = $request->input('nombre');
       $especialidad->descripcion = $request->input('descripcion');
       $especialidad->save();

       $notificacion = 'La especialidad se ha actualizado correctamente';
        return redirect('especialidades')->with(compact('notificacion'));
   }

   public function destroy(Especialidad $especialidad){
    $especialidadEliminada = $especialidad->nombre;
    $especialidad->delete();

    $notificacion = 'La especialidad '.$especialidadEliminada.' se ha eliminado correctamente';
    return redirect('especialidades')->with(compact('notificacion'));
} 

}
