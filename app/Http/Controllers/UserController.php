<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function edit(){
        $user= auth()->user();
        return view('perfil', compact('user'));
    }

    public function update(Request $request){

        $user= auth()->user();

        $user->nombre= $request->nombre;
        $user->telefono= $request->telefono;
        $user->direccion= $request->direccion;

        $user->save();

        $notificacion= "Los datos han sido actualizados satisfactoriamente";

        return back()->with(compact('notificacion'));
    }
}
