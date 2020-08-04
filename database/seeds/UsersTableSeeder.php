<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder

{
    public function run()
    {

        User::create([   
            'nombre' => 'Gerhard Rondan',
            'email' => 'ingerhard@hotmail.com',
            'password' => bcrypt('hola1234'), // password
            'remember_token' => Str::random(10),
            'dni' => '43655864',
            'direccion' => '',
            'telefono' => '',
            'rol' => 'administrador'
        ]);
        User::create([   
            'nombre' => 'Medico 1',
            'email' => 'doctor@hotmail.com',
            'password' => bcrypt('hola12'),
            'dni' => '43655861',
            'rol' => 'doctor'
        ]);
        User::create([   
            'nombre' => 'Paciente 1',
            'email' => 'paciente@hotmail.com',
            'password' => bcrypt('hola12'), 
            'dni' => '43655862',            
            'rol' => 'paciente'
        ]);
        factory(User::class, 50)->states('paciente')->create();
        
    }
}
