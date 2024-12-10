<?php

namespace App\Livewire;

use App\Facades\Bics\Bics as BicsAlias;
use Livewire\Component;

class EndpointDelete extends Component
{
    public $dropdown_iccid;

    public $range_from_iccid;

    public $range_to_iccid;

    public $sims;

    public $failed = [];

    protected $listeners = [
        'delete' => 'delete',
    ];

    public function delete()
    {
        if (($this->range_from_iccid && $this->range_to_iccid) && (is_int((int) $this->range_from_iccid) && is_int((int) $this->range_to_iccid))) {
            if ($this->range_from_iccid > $this->range_to_iccid) {
                $this->dispatch('simRangeError');

                return false;
            }

            $i = $this->range_from_iccid;
            while ($i <= $this->range_to_iccid) {
                $numbers[] = collect($this->sims)->where('serial_no', $i)->first()['endpointId'] ?? null;
                $i++;
            }
            $response = BicsAlias::deleteEndpoints($numbers);
        } elseif ($this->dropdown_iccid) {
            $response = BicsAlias::deleteEndpoints([$this->dropdown_iccid]);
        }

        if (! isset($response)) {
            return;
        }
        $failed = [];
        foreach ($response as $item) {
            $failed[] = collect($this->sims)->where('endPointId', $item)->first()['serial_no'] ?? null;
        }
        $this->failed = $failed;
        $this->dispatch('deleteSuccess', response: $failed);
    }

    public function render()
    {
        $bicsSims = BicsAlias::getAssignedSims();

        $sims = [];
        foreach ($bicsSims as $bicsSim) {
            $serial = collect($bicsSim['iMSIList'][0]['supplierIMSIList']);
            $serial = $serial->where('supplierName', 'IR1')->first()['supplierIMSI'] ?? null;
            if (! $serial) {
                continue;
            }
            $sims[] = [
                'iccid' => $bicsSim['iccid'],
                'serial_no' => $serial,
                'endpointId' => $bicsSim['endPointId'],
            ];
        }

        $this->sims = $sims;

        return view('livewire.endpoint-delete');
    }
}
