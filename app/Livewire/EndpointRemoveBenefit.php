<?php

namespace App\Livewire;

use App\Facades\Bics\Bics;
use App\Models\Benefit;
use Livewire\Component;

class EndpointRemoveBenefit extends Component
{
    public $sim;

    public $benefit;

    protected $listeners = [
        'remove' => 'remove',
    ];

    public function remove()
    {
        if (! $this->benefit) {
            return;
        }
        $benefit = Benefit::find($this->benefit);

        $benefits = [$benefit->bics_id];

        if ($benefit->linked_benefit) {
            $benefits[] = $benefit->linked_benefit;
        } elseif ($linkedBene = Benefit::where('linked_benefit', $benefit->bics_id)->first()) {
            $benefits[] = $linkedBene->bics_id;
        }

        $this->sim->syncBenefits();

        $response = Bics::removeBenefits($this->sim->current_endpoint, $benefits);

        foreach ($benefits as $benefit) {
            Benefit::where('bics_id', $benefit)->update(['status' => 'cancelled']);
        }

        if ($response) {
            $this->dispatch('removeSuccess');
            $this->render();
        }
    }

    public function render()
    {
        return view('livewire.endpoint-remove-benefit')->with([
            'endpoints' => $this->sim?->endpoints,
        ]);
    }
}
