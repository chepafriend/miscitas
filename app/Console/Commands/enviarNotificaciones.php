<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Cita;

class enviarNotificaciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fcm:enviar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar mensajes via FCM';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Buscando citas medica con estado confirmadas en las proximas 24 horas');
        
        $ahora = Carbon::now();

        $headers= ['id', 'fecha_programada', 'hora_programada', 'paciente_id'];

        $citasManana= $this->getCitas24Horas($ahora->copy());
        $this->table($headers, $citasManana->toArray());
        
        foreach($citasManana as $cita){
            $cita->paciente->enviarFCM('No olvides tu cita mañana a esta Hora');
            $this->info('Mensaje FCM enviado 24h antes al paciente con (ID): '. $cita->paciente_id);
    }

        $citasSiguienteHora= $this->getCitasSiguienteHora($ahora->copy());
        $this->table($headers, $citasSiguienteHora->toArray());

        foreach($citasSiguienteHora as $cita){
            $cita->paciente->enviarFCM('Tienes una cita en 1 hora te esperamos');
            $this->info('Mensaje FCM enviado 1h antes al paciente con (ID): '. $cita->paciente_id);
    }
}

    private function getCitas24Horas($ahora)
    {
        return Cita::where('estado', 'Confirmada')
        ->where('fecha_programada', $ahora->addDay()->toDateString())
        ->where('hora_programada','>=', $ahora->copy()->subMinutes(3)->toTimeString())
        ->where('hora_programada','<', $ahora->copy()->addMinutes(2)->toTimeString())
        ->get(['id', 'fecha_programada', 'hora_programada', 'paciente_id']);
    }

    private function getCitasSiguienteHora($ahora)
    {
        return Cita::where('estado', 'Confirmada')
        ->where('fecha_programada', $ahora->addHour()->toDateString())
        ->where('hora_programada','>=', $ahora->copy()->subMinutes(3)->toTimeString())
        ->where('hora_programada','<', $ahora->copy()->addMinutes(2)->toTimeString())
        ->get(['id', 'fecha_programada', 'hora_programada', 'paciente_id']);
    }

}
