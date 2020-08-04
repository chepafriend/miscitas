<?php

use Illuminate\Database\Seeder;
use App\Cita;

class CitasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Cita::class, 300)->create();
    }
}
