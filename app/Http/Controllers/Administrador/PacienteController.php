<?php

namespace App\Http\Controllers\Administrador;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;

class PacienteController extends Controller
{
    private  function performValidation(Request $request){
        $rules=[
            'nombre'=>'required|min:3',
            'email'=>'required|email',
            'dni'=>'digits:8',
            'direccion'=>'min:5|nullable',
            'telefono'=>'min:6|nullable'
        ];
        $messages=[
            'nombre.required'=>"Es necesario ingresar un nombre.",
            'nombre.min'=>"Como mínimo el nombre debe tener 3 caracteres.",
            'email.required'=>"Es necesario ingresar un email.",
            'email.email'=>"Es necesario ingresar un email valido.",
            'dni.digits'=>"El DNI debe tener 8 caracteres.",
            'direccion.min'=>"Como mínimo la direccion debe tener 5 caracteres.",
            'telefono.min'=>"Como mínimo el telefono debe tener 6 caracteres.",
        ];
        $this->validate($request, $rules, $messages);

    }

    public function index()
    {
        $pacientes = User::pacientes()->paginate(5);

        return view('pacientes.index', compact('pacientes'));
    }

    public function create()
    {
        return view('pacientes.create');
    }

    public function store(Request $request)
    {
        $this->performValidation($request);
        User::create($request->only('nombre', 'email', 'dni', 'direccion', 'telefono')
                + ['rol'=>'paciente',
                    'password'=>bcrypt($request->input('password'))
                    ]
                );

        $notificacion= 'El paciente se registro correctamente';

        return redirect('pacientes')->with(compact('notificacion'));

    }
    public function show($id)
    {
        //
    }
    
    public function edit($id)
    {
        $paciente= User::FindOrFail($id);

        return view('pacientes.edit', compact('paciente'));
    }

        public function update(Request $request, $id)
    {
        $this->performValidation($request);

        $user= User::pacientes()->FindOrFail($id);

        $data= $request->only('nombre', 'email', 'dni', 'direccion', 'telefono');
        $password=$request->input('password');
        if($password)
            $data['password']= bcrypt($password);
        
        $user->fill($data);
        $user->save();
            
        $notificacion= 'Los datos del paciente se actualizaron correctamente';

        return redirect('pacientes')->with(compact('notificacion'));
    }

    
    public function destroy($id)
    {
        $paciente= User::pacientes()->FindOrFail($id);
        $nombrepaciente = $paciente->nombre;

        $paciente->delete();

        $notificacion= "Los datos del paciente $nombrepaciente se eliminaron correctamente";

        return redirect('pacientes')->with(compact('notificacion'));
    }
}
