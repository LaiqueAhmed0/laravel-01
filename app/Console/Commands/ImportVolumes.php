<?php

namespace App\Console\Commands;

use App\Facades\Bics\Import;
use Illuminate\Console\Command;

class ImportVolumes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bics:import:volumes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Volumes';

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
        Import::unZip();
    }
}
