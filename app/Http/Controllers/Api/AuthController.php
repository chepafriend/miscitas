<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\User;

class AuthController extends Controller
{
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

    public function registro(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        Auth::login($user);

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;       
        $token->save();
        $accesToken = $tokenResult->accessToken;
        $exito = true;

        return compact('exito', 'user','accesToken');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, User::$rules);
    }
    
    protected function create(array $data)
    {
        return User::crearPaciente($data);
    }
}
