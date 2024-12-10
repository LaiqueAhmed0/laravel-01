<?php

namespace App\Console\Commands;

use App\Facades\Bics\Bics;
use App\Jobs\AddSims;
use Illuminate\Console\Command;

class SyncSims extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bics:get:sims';

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
        $sims = Bics::sims(41, 250);

        $total = $sims['totalNoOfPages'];
        for ($i = 1; $i <= ($sims['totalNoOfPages']); $i++) {
            AddSims::dispatch($i);
        }

        return 0;
    }
}
