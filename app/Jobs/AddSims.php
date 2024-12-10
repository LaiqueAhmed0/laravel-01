<?php

namespace App\Jobs;

use App\Facades\Bics\Bics;
use App\Models\Sim;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AddSims implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $page;

    public function middleware()
    {
        return [new WithoutOverlapping('2')];
    }

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($page)
    {
        //
        $this->page = $page;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::alert('trigger Job');
        $sims = Bics::sims($this->page, 250);
        try {
            $addedSims = 0;
            $skippedSims = 0;
            foreach ($sims['responseParam']['rows'] as $sim) {
                if (Sim::where('bics_id', $sim['simId'])->exists()) {
                    $skippedSims++;
                } else {
                    $addedSims++;
                    Sim::create([
                        'iccid' => $sim['iccid'],
                        'serial_no' => (collect($sim['iMSIList'][0]['supplierIMSIList'])->where('sponsorName', 'IR1')->first()['supplierIMSI'] ?? 'N/A'),
                        'bics_id' => $sim['simId'],
                    ]);
                }
            }

            dump($skippedSims);
        } catch (\Exception $exception) {
            Log::alert($sims);
        }
    }
}
