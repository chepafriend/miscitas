<?php

namespace App\Http\Controllers\Administrador;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class FirebaseController extends Controller
{
    public function enviarTodos(Request $request){
      
        $recipients= User::whereNotNull('device_token')->pluck('device_token')->toArray();
            
        fcm()
            ->to($recipients) // $recipients must an array
            ->priority('high')
            ->timeToLive(0)
            ->notification([
                'title' => $request->input('title'),
                'body' => $request->input('body')
        ])
        ->send();

        $notificacion="notificacion enviada a todos los usuarios android";

        return back()->with(compact('notificacion'));
    }
}
