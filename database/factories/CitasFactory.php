<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\User;
use App\Cita;

$factory->define(Cita::class, function (Faker $faker) {

    $doctorIds = User::doctores()->pluck('id');
    $pacienteIds = User::pacientes()->pluck('id');

    $fecha= $faker->dateTimeBetween('-1 years', 'now');

    $fecha_programada= $fecha->format('Y-m-d');
    $hora_programada= $fecha->format('H:i:s');

    $tipos= ['Consulta', 'Examen', 'Operacion'];
    $estados= ['atendida', 'cancelada'];

    return [

        'descripcion'=>$faker->sentence(5),
        'especialidad_id'=>$faker->numberBetween(1, 3),
        'doctor_id'=>$faker->randomElement($doctorIds),
        'paciente_id'=>$faker->randomElement($pacienteIds),
        'fecha_programada'=>$fecha_programada,
        'hora_programada'=>$hora_programada,
        'tipo'=>$faker->randomElement($tipos),
        'estado'=>$faker->randomElement($estados)
    ];
});
