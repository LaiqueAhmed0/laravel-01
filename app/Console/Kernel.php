<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Queue\Console\WorkCommand;
use Laravel\Telescope\Console\PruneCommand as TelescopePruneCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\SyncTopup::class,
        Commands\ImportVolumes::class,
        Commands\SyncEndpoints::class,
        Commands\SyncSims::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(TelescopePruneCommand::class, ['--hours' => 24 * 7])->daily();

        $schedule->command('bics:import:volumes')->everyFiveMinutes();
        $schedule->command('bics:sync:sims')->hourly();
        $schedule->command('bics:sync:destinations')->daily();
        $schedule->command('bics:apply:topup')->everyFiveMinutes();

        $schedule->command(WorkCommand::class, [
            '--max-time' => 60,
            '--stop-when-empty' => true,
        ])->everyMinute()->withoutOverlapping();
    }

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
