<?php

namespace App\Console\Commands;

use App\Models\TurnoIngreso;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class TestTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cerrar turnos';

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
     * @return int
     */
    public function handle()
    {

        $objturno= new TurnoIngreso();
        $turnos=TurnoIngreso::where('estado',1)->get();

        foreach ($turnos as $value) {
            $objturno->close_turn($value->id,$value->sucursal_id);
        }

        $texto = "[".date('H:i:s')."] Tarea terminada";
        Storage::append("archivo.txt", $texto);

    }
}
