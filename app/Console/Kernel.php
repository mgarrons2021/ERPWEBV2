<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected $commands=[
        Commands\TestTask::class
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('test:task')->dailyAt('10:24');
    }

    //dailyAt('17:05');
//ir a tareas programadas de windows y enlazar el archivo task.bat para que se ejecute en segundo plano este archivo
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

