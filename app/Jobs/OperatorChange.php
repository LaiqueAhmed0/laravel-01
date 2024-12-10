<?php

namespace App\Jobs;

use App\Models\Country;
use App\Models\Sim;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class OperatorChange implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $iccid;

    public $operator;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($operator, $iccid)
    {
        $this->iccid = $iccid;
        $this->operator = $operator;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sim = Sim::where('iccid', $this->iccid)->first();

        $country = Country::all()->filter(function ($item) {
            if ($operators = json_decode($item->operators)) {
                return collect($operators)->where('id', $this->operator)->count();
            }

            return false;
        })->first();

        if (! (! in_array($country['id'], $sim->current_endpoint->benefit->plan->countries) && $endpoint = $sim->getEndpointWherePlanCountry($country['id']))) {
            return;
        }
        if ($endpoint->scheduled && $endpoint->scheduled < Carbon::now()) {
            return;
        }
        $sim->switchEndpoint($endpoint);
    }
}
