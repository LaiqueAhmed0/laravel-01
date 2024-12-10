<?php

namespace App\Console\Commands;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SyncTopup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bics:apply:topup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send newly scheduled topups to bics';

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
        foreach (Order::whereIn('status', ['completed', 'processing'])->get() as $order) {
            foreach ($order->orderItems()->where('applied', '0')->get() as $item) {
                if ((! $item->scheduled || $item->scheduled >= Carbon::now()) && $item->scheduled !== null) {
                    continue;
                }

                for ($i = 0; $i < $item->quantity; $i++) {
                    $item->sim->addPlan($item->plan, $item->id);
                }

                $item->update(['applied' => 1]);

                $item->order->status = 'completed';
                $item->order->save();
            }
        }
    }
}
