<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    public function show(){
        return Auth::user();
}

    public function update(Request $request){
        $user= Auth::user();

        $user->nombre= $request->nombre;
        $user->telefono= $request->telefono;
        $user->direccion= $request->direccion;

        $user->save();

    }
}