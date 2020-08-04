<?php

namespace App\Http\Controllers\Administrador;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Especialidad;

class DoctorController extends Controller
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
        $doctores = User::doctores()->get();

        return view('doctores.index', compact('doctores'));
    }

    public function create()
    {
        $especialidades = Especialidad::all();
        return view('doctores.create', compact('especialidades'));
    }

    public function store(Request $request)
    {
        $this->performValidation($request);
        $user = User::create($request->only('nombre', 'email', 'dni', 'direccion', 'telefono')
                + ['rol'=>'doctor',
                    'password'=>bcrypt($request->input('password'))
                    ]
                );
        $user->especialidades()->attach($request->input('especialidades'));
        $notificacion= 'El médico se registro correctamente';
        return redirect('doctores')->with(compact('notificacion'));

    }
    public function show($id)
    {
        //
    }
    
    public function edit($id)
    {
        $doctor= User::FindOrFail($id);
        $especialidades= Especialidad::all();
        $especialidad_ids= $doctor->especialidades()->pluck('especialidads.id');
        return view('doctores.edit', compact('doctor', 'especialidades','especialidad_ids'));
    }

        public function update(Request $request, $id)
    {
        $this->performValidation($request);

        $user= User::doctores()->FindOrFail($id);

        $data= $request->only('nombre', 'email', 'dni', 'direccion', 'telefono');
        $password=$request->input('password');
        if($password)
            $data['password']= bcrypt($password);
        
        $user->fill($data);
        $user->save();
         
        $user->especialidades()->sync($request->input('especialidades'));
        $notificacion= 'Los datos del Médico se actualizaron correctamente';
        return redirect('doctores')->with(compact('notificacion'));
    }

    
    public function destroy($id)
    {
        $doctor= User::doctores()->FindOrFail($id);
        $nombreDoctor = $doctor->nombre;

        $doctor->delete();

        $notificacion= "Los datos del Médico $nombreDoctor se eliminaron correctamente";

        return redirect('doctores')->with(compact('notificacion'));
    }
}
