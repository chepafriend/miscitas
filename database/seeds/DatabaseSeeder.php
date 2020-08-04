<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Especialidad;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,            
            EspecialidadesTableSeeder::class,
            DiasLaborablesTableSeeder::class,
            CitasTableSeeder::class,
        ]); 
}
}