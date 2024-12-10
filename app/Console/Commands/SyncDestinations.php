<?php

namespace App\Console\Commands;

use App\Facades\Bics\Bics;
use Illuminate\Console\Command;

class SyncDestinations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bics:sync:destinations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all sims and sync them to the database';

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
        Bics::addOperatorsToCountries();
        Bics::updateRateZones();

        return 0;
    }
}
