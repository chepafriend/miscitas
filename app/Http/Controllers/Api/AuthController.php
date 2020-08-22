<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function signUp(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);

        User::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    /**
     * Inicio de sesión y creación de token
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credenciales = $request->only('email', 'password');

        if (!Auth::attempt($credenciales)){
                $exito = false;
                $mensaje = "Datos incorrectos";
                return compact('exito', 'mensaje');
        } else {        
                    $user = Auth::user();
                    $tokenResult = $user->createToken('Personal Access Token');
                    $token = $tokenResult->token;       
                    $token->save();
                    $accesToken = $tokenResult->accessToken;
                    $exito = true;

                    return compact('exito', 'user','accesToken');
        }

       // return response()->json([
            //'access_token' => $tokenResult->accessToken,
            //'token_type' => 'Bearer',
           // 'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
      //  ]);
    }

    /**
     * Cierre de sesión (anular el token)
     */
    public function logout(Request $request)
    {
        Auth::user()->token()->revoke();
        
        $exito = true;
        return compact('exito');
        
    }

    /**
     * Obtener el objeto User como json
     */
   
    //
}
