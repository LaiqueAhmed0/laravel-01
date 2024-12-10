<?php

namespace App\Livewire\Dashboard\User;

use Livewire\Component;

class LiveData extends Component
{
    public $sim;

    public function render()
    {
        return view('livewire.dashboard.user.live-data');
    }
}
