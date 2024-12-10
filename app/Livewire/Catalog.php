<?php

namespace App\Livewire;

use App\Models\Plan;
use App\Models\Sim;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Catalog extends Component
{
    public $embed = false;

    public $search;

    public $filter = [
        'credit' => [],
        'rate' => [],
        'country' => 'all',
    ];

    use WithPagination;

    protected $listeners = [
        'countryUpdated' => 'countryUpdated',
    ];

    protected $paginationTheme = 'bootstrap';

    public function resetFilters()
    {
        $this->filter = [
            'credit' => [],
            'rate' => [],
            'country' => 'all',
        ];
    }

    public function countryUpdated($country)
    {
        $this->filter['country'] = $country;
    }

    public function mount()
    {
        $this->search = null;
        $this->filter['rate'] = 'all';
    }

    public function updatedPriceFrom()
    {
        //        dd($this->priceTo, $this->priceFrom);
    }

    public function hydrate()
    {
        $this->dispatch('select2');
    }

    public function render()
    {
        $plans = Plan::search($this->search)->where('type', 'admin')->filterRate($this->filter['rate'])->filterCredit($this->filter['credit'])->filterCountry($this->filter['country'])->get();

        if ($this->embed) {
            return view('livewire.catalog')->with([
                'products' => $plans,
            ]);
        }

        $user = Auth::user();

        if ($user->group == 2) {
            $sims = $user->retailer->sims;
        } elseif ($user->group == 3) {
            $sims = Sim::all();
        } else {
            $sims = $user->sims;
        }

        return view('livewire.catalog')->with([
            'products' => $plans,
            'sims' => $sims,
        ]);
    }
}
