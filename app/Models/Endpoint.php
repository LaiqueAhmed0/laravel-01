<?php

namespace App\Models;

use App\Facades\Bics\Bics;
use App\Facades\Topup;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endpoint extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
    ];

    protected $bicsEndpoint;

    public function getCurrentBenefitAttribute()
    {
        return $this->benefits()->latest()->first()->plan->name ?? 'No Plan';
    }

    public function benefits()
    {
        return $this->hasMany(Benefit::class);
    }

    public function getExpiryFromBics()
    {
        $benefits = collect($this->getBenefitsFromBics() ?? []);
        $dates = [];
        foreach ($benefits as $benefit) {
            if ($benefit['expiryDate'] != '-') {
                $dates[] = Carbon::createFromFormat('d/m/Y H:i:s', $benefit['expiryDate']);
            }
        }
        if (count($dates) == 0) {
            return null;
        } elseif (count($dates) == 1) {
            return $dates[0];
        } else {
            return max($dates);
        }
    }

    public function getStartFromBics()
    {
        $benefits = collect($this->getBenefitsFromBics() ?? []);
        $dates = [];
        foreach ($benefits as $benefit) {
            if ($benefit['startDate'] != '-') {
                $dates[] = Carbon::createFromFormat('d/m/Y H:i:s', $benefit['startDate']);
            }
        }

        return min($dates);
    }

    public function scopeNotExpired($query)
    {
        $query->where('expiry', '>', Carbon::now())->orWhere('expiry', null);
    }

    public function getStartDateFormattedAttribute()
    {
        return Carbon::parse($this->start_date)->format('d/m/Y');
    }

    public function getScheduledFormattedAttribute()
    {
        return Carbon::parse($this->scheduled)->format('d/m/Y');
    }

    public function getExpiryFormattedAttribute()
    {
        return Carbon::parse($this->expiry)->format('d/m/Y');
    }

    public function getIsExpiredAttribute()
    {
        return $this->expiry && $this->expiry < Carbon::now();
    }

    public function getStatusAttribute()
    {
        $benefits = collect($this->getBenefitsFromBics() ?? []);
        $status = 'Inactive';

        foreach ($benefits as $benefit) {
            if ($benefit['expiryDate'] != '-') {
                $expiry = Carbon::createFromFormat('d/m/Y H:i:s', $benefit['expiryDate']);
            }

            if ($benefit['startDate'] == '-') {
                if ($status != 'Active') {
                    $status = 'Waiting for first use';
                }
            } elseif (isset($expiry) && $expiry->isPast()) {
                if ($status != 'Active' && $status != 'Waiting for first use') {
                    $status = 'Expired';
                }
            } else {
                $status = 'Active';
            }
        }

        return $status;
    }

    public function getRetailerAttribute()
    {
        if (! $this->retailer_id) {
            return 'No Retailer';
        }

        $retailer = Retailer::find($this->retailer_id);

        return $retailer->name;
    }

    public function getClaimedByAttribute()
    {
        if (! $this->user_id) {
            return 'Not Assigned';
        }

        $user = User::find($this->user_id);

        return $user->first_name.' '.$user->last_name;
    }

    public function getClaimedByEmailAttribute()
    {
        if (! $this->user_id) {
            return 'Not Assigned';
        }

        $user = User::find($this->user_id);

        return $user->email;
    }

    public function getPlansFromBics()
    {
        $this->bicsEndpoint = Bics::getEndpoint($this->bics_id);

        return collect($this->bicsEndpoint['info']['promotionalPlans']['plan'] ?? [])->where('planServiceName', 'DATA')->sortBy('uniqueId');
    }

    public function getBicsSim()
    {
        return Bics::getSim($this->iccid);
    }

    public function sim()
    {
        return $this->belongsTo(Sim::class);
    }

    public function getBicsEndpoint()
    {
        if ($this->bicsEndpoint) {
            return $this->bicsEndpoint;
        }
        try {
            $this->bicsEndpoint = Bics::getEndpoint($this->bics_id);
        } catch (\Exception $exception) {
            return false;
        }

        return $this->bicsEndpoint;
    }

    public function getBenefitsFromBics()
    {
        $endpoint = $this->getBicsEndpoint();

        return collect($endpoint['info']['benefitInfo']['benefit'] ?? [])->where('name', 'DATA');
    }

    public function getBenefitsFromBicsFormattedAttribute()
    {
        $data = [];
        $benefits = $this->getBenefitsFromBics();

        foreach ($benefits as $key => $bicsBenefit) {
            if (! isset($bicsBenefit['uniqueId'])) {
                continue;
            }
            $benefit = \App\Models\Benefit::where('bics_id', $bicsBenefit['uniqueId'])->where('linked_benefit', null)->first();
            if ($benefit) {
                $benefits->forget($key);
                $benefit->bics = [$bicsBenefit];
                $data[$benefit->bics_id] = $benefit;
            }
        }

        foreach ($benefits as $key => $bicsBenefit) {
            if (! isset($bicsBenefit['uniqueId'])) {
                continue;
            }
            $benefit = \App\Models\Benefit::where('bics_id', $bicsBenefit['uniqueId'])->where('linked_benefit', '!=', null)->first();
            if ($benefit && isset($data[$benefit->linked_benefit]) && count($data[$benefit->linked_benefit]->bics) != 2) {
                $data[$benefit->linked_benefit]->bics = array_merge($data[$benefit->linked_benefit]->bics, [$bicsBenefit]);
            }
        }

        return $data;
    }

    public function getASumFromBenefit($key)
    {
        return $this->getBenefitsFromBics()->sum($key);
    }

    public function getPlanJsonAttribute()
    {
        return null;
    }

    public function getPlansAttribute()
    {
        $plans = $this->getPlansFromBics();
        $loaded = [];

        foreach ($this->benefits as $benefit) {
            $loaded[$benefit->id] = [
                'plan' => [],
                'localBenefit' => $benefit,
            ];

            foreach (json_decode($benefit->bics_id) as $id) {
                if ($plans->where('uniqueId', (int) $id)->count()) {
                    $loaded[$benefit->id]['plan'][] = $plans->where('uniqueId', $id)->first();
                }
            }
        }

        return $loaded;
    }

    public function getNextTopupAttribute()
    {
        return $this->hasMany(Topup::class)->where('status', 'waiting')->oldest()->first() ?? false;
    }

    public function getUsagePercentage()
    {
        return $this->getASumFromBenefit('actualBalance') ? round(((($this->getASumFromBenefit('actualBalance')) - ($this->getASumFromBenefit('balance'))) / ($this->getASumFromBenefit('actualBalance'))) * 100, 2) : 0;
    }

    public function getVolumeLimitAttribute()
    {
        return ($this->getASumFromBenefit('actualBalance') ?? 0) / 1024 / 1024;
    }

    public function getVolumeAttribute()
    {
        //        dd($this->getBenefitsFromBics());

        return (($this->getASumFromBenefit('actualBalance') ?? 0) / 1024 / 1024) - (($this->getASumFromBenefit('balance') ?? 0) / 1024 / 1024);
    }

    public function getVolumeRemainingAttribute()
    {
        return ($this->getASumFromBenefit('balance') ?? 0) / 1024 / 1024;
    }

    public function getBreakdownAttribute()
    {
        $to = Carbon::now();
        $from = $to->clone()->subDays(30);

        if ($from && $to) {
            // return $this->volume()->orderBy('date', 'DESC')->whereBetween('date', [$from->startOfDay(), $to->endOfDay()])->get() ?? false;
        }

        return false;
    }

    public function getBreakdownChartFormattedAttribute()
    {
        $to = Carbon::now();
        $from = $to->clone()->subDays(30);

        if ($from && $to) {
            // return Usage::chart($this->getBreakdownAttribute(), [$from->startOfDay(), $to->endOfDay()]) ?? ['data' => [], 'labels' => []];
        }

        return false;
    }

    public function benefit()
    {
        return $this->hasOne(Benefit::class);
    }

    public function volume()
    {
        return $this->hasMany(Volume::class, 'endpoint', 'bics_id');
    }

    public static function findBasedOnValue($column, $val)
    {
        return self::where($column, $val)->first();
    }

    public static function getUserEndpoints($user)
    {
        return self::where('user_id', $user)->get();
    }
}
