<?php

namespace App\Livewire;

use App\Models\Pricing;
use Livewire\Component;

class PricingForm extends Component
{
    public $new_condition = [];

    public $conditions = [];

    public $name = '';

    public $markup = 0;

    public $countries = [];

    public $regions = [];

    public $pricing;

    protected $listeners = [
        'countriesUpdated' => 'countriesUpdated',
    ];

    public function countriesUpdated($value)
    {
        $this->countries = $value;
    }

    public function addCondition()
    {
        $data = $this->validate([
            'new_condition.operator' => 'required',
            'new_condition.attribute' => 'required',
            'new_condition.value' => 'required',
        ])['new_condition'];
        $this->conditions[] = $data;
    }

    public function mount()
    {
        if (! $this->pricing) {
            return;
        }
        $this->conditions = json_decode($this->pricing->conditions, true) ?? [];

        $this->regions = json_decode($this->pricing->regions, true) ?? [];
        $this->countries = json_decode($this->pricing->countries, true) ?? [];
        $this->markup = $this->pricing->markup;
        $this->name = $this->pricing->name;
    }

    public function create()
    {
        $data = [
            'name' => $this->name,
            'markup' => $this->markup,
            'countries' => json_encode($this->countries),
            'conditions' => json_encode($this->conditions),
        ];

        if ($this->pricing) {
            $this->pricing->update($data);
        } else {
            Pricing::create($data);
        }
    }

    public function render()
    {
        return view('livewire.pricing-form');
    }

    public function removeCondition($key)
    {
        unset($this->conditions[$key]);
    }
}
