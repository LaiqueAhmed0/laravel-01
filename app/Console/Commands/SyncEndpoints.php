<?php

namespace App\Console\Commands;

use App\Facades\Bics\Bics;
use App\Models\Benefit;
use App\Models\Endpoint;
use App\Models\Plan;
use App\Models\Sim;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SyncEndpoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bics:sync:sims';

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
        foreach (Benefit::where('status', 'queued')->get() as $benefit) {
            $plans = $benefit->endpoint->getPlansFromBics();

            if (! in_array($benefit->bics_id, $plans->pluck('uniqueId')->toArray())) {
                $benefit->status = 'expired';
                $benefit->save();
            }
        }

        foreach (Benefit::where('status', 'expired')->get() as $benefit) {
            $plans = $benefit->endpoint->getPlansFromBics();

            if (in_array($benefit->bics_id, $plans->pluck('uniqueId')->toArray())) {
                $benefit->status = 'queued';
                $benefit->save();
            }
        }

        //        $sims = Bics::sims();
        //        foreach ($sims['responseParam']['rows'] as $sim) {
        //            if (Sim::where('iccid', $sim['iccid'])->exists()) {
        //                break;
        //            }
        //
        //            Sim::create([
        //                'iccid' => $sim['iccid'],
        //                'serial_no' => (collect($sim['iMSIList'][0]['supplierIMSIList'])->where('sponsorName', 'IR1')->first()['supplierIMSI'] ?? 'N/A'),
        //                'bics_id' => $sim['simId']
        //            ]);
        //        }

        //        $endpoints = Endpoint::where('expiry', null)->get();

        //        foreach ($endpoints as $endpoint) {
        //
        //            if ($expiry = $endpoint->getExpiryFromBics()) {
        //                if ($endpoint->benefit->hybrid) {
        //                    Bics::addBenefitManualy($endpoint, $endpoint->benefit->plan->bics_id[1]);
        //                    $plans = $endpoint->getPlansFromBics();
        //                    $benefit = $endpoint->benefit;
        //                    $benefit->bics_id = json_encode($plans->sortByDesc('uniqueId')->take(2)->pluck('uniqueId')->toArray());
        //                    $benefit->save();
        //                }
        //
        //                if ($start = $endpoint->getStartFromBics()) {
        //                    $endpoint->start_date = $start;
        //                }
        //
        //                $endpoint->expiry = $expiry;
        //                $endpoint->save();
        //            }
        //            Bics::activateEndpoint($endpoint);
        //        }
        //
        //        foreach (Endpoint::where('expiry', '!=', null)->get() as $endpoint) {
        //            if ($endpoint->volume_remaining < 0.01) {
        //                $endpoint->update([
        //                    'active' => 0,
        //                    'expiry' => Carbon::now()
        //                ]);
        //                $endpoint->sim->switchToNextQueuedEndpoint();
        //            }
        //            if ($expiry = $endpoint->getExpiryFromBics()) {
        //                $expiry = Carbon::parse($expiry);
        //                if ($expiry < Carbon::now()) {
        //                    $endpoint->update([
        //                        'active' => 0,
        //                        'expiry' => Carbon::now()
        //                    ]);
        //                    $endpoint->sim->switchToNextQueuedEndpoint();
        //                }
        //            }
        //        }

        return 0;
    }
}
