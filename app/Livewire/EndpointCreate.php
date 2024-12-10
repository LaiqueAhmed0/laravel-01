<?php

namespace App\Livewire;

use App\Models\Plan;
use App\Models\Retailer;
use App\Models\Sim;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EndpointCreate extends Component
{
    public ?int $iccid_from = null;

    public ?int $iccid_to = null;

    public ?int $plan = null;

    public ?int $retailer = null;

    protected $listeners = [
        'create' => 'create',
    ];

    public function __construct($id = null)
    {
        $this->setId($id);
    }

    public function create()
    {
        $this->validate([
            'iccid_from' => ['required', 'numeric', Rule::when(fn ($a) => isset($a['iccid_to']), 'lte:iccid_to')],
            'iccid_to' => ['nullable',  'numeric', Rule::when(fn ($a) => isset($a['iccid_from']), 'gte:iccid_from')],
            'plan' => ['required', 'exists:plans,id'],
            'retailer' => ['nullable', 'exists:retailers,id'],
        ]);

        $iccids = range($this->iccid_from, $this->iccid_to ?? $this->iccid_from);
        $plan = Plan::findOrFail($this->plan);
        $sims = Sim::whereIn('iccid', array_map('strval', $iccids));

        foreach ($sims->lazy() as $sim) {
            dispatch(function () use ($sim, $plan) {
                $sim->addPlan($plan);
                $sim->update(['retailer_id' => $this->retailer]);
            });
        }

        $this->dispatch('createSuccess');
    }

    public function render()
    {
        return view('livewire.endpoint-create')->with([
            'sims' => Sim::all(['iccid', 'serial_no']),
            'retailers' => Retailer::all(['id', 'name']),
            'plans' => Plan::all(['id', 'name']),
        ]);
    }
}
