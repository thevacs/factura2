<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ProfitVC::class,
        Commands\ProfitVC2::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        // Dos veces al día a las 6 a las y a las 15 (3 pm)
        // $schedule->command('sync:divisa')->twiceDaily(6, 15);

        // Ganancias Vargas Container
        $schedule->command('profit:vargascontainer')
            ->twiceDaily(11, 17)
            ->runInBackground();

        // Ganancias Vargas Container 2
        /*$schedule->command('profit:vargascontainer2')
            ->everyMinute()
            ->runInBackground();*/
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    protected function scheduleTimezone()
    {
        return 'America/Caracas';
    }
}
