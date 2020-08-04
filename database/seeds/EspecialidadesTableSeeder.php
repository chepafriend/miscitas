<?php

use Illuminate\Database\Seeder;
use App\Especialidad;
use App\User;

class EspecialidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $especialidades = ['Oftalmología', 'Pediatría', 'Neurología'];

        foreach($especialidades as $especialidadNombre){

           $especialidad = Especialidad::create( 
                ['nombre' => $especialidadNombre]);

            $especialidad->users()->saveMany(
                factory(User::class, 3)->states('doctor')->make()
            );           
        }
        User::find(2)->especialidades()->save($especialidad);
    }
}
