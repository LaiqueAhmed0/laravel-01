<?php

namespace App\Jobs;

use App\Models\Plan;
use App\Models\Sim;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddPlanToSim implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;

    public $sim;

    public $plan;

    public $id;

    public $scheduled;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($sim, $plan, $id = null, $scheduled = null)
    {
        $this->sim = $sim;
        $this->plan = $plan;
        $this->id = $id;
        $this->scheduled = $scheduled;
    }

    /**\
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $plan = Plan::find($this->plan);

        $sim = Sim::where('iccid', $this->dropdown_iccid)->first();
        $sim->addPlan($plan);
        $sim->update([
            'retailer_id' => $this->retailer,
        ]);

        $this->release(180);
    }
}
