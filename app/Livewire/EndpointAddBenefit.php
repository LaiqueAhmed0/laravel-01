<?php

namespace App\Livewire;

use App\Models\Plan;
use Livewire\Component;

class EndpointAddBenefit extends Component
{
    public $endpoint;

    public $sim;

    public $plan;

    protected $listeners = [
        'add' => 'add',
    ];

    public function add()
    {
        if ($this->plan) {
            $this->sim->addPlan(Plan::find($this->plan));
            $this->dispatch('createSuccess');
        }
    }

    public function render()
    {
        return view('livewire.endpoint-add-benefit')->with([
            'plans' => Plan::all(),
        ]);
    }
}
