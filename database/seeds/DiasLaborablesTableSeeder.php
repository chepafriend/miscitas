<?php

use Illuminate\Database\Seeder;
use App\Dialaborable;

class DiasLaborablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
        for($i=0; $i<7; ++$i)
        {
            Dialaborable::create([
                'dia'   =>$i,
                'activo'=>($i==3),
                'inicio_manana'=>($i==3 ? '07:00:00' : '05:00:00'),
                'fin_manana'=>($i==3 ? '09:30:00' : '05:00:00'),
                'inicio_tarde'=>($i==3 ? '15:00:00' : '13:00:00'),
                'fin_tarde'=>($i==3 ? '18:00:00' : '13:00:00'),
                'user_id'=>2
            ]);

        }        
    }
}
