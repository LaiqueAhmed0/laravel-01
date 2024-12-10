<?php

namespace App\Facades\Bics;

use Illuminate\Support\Facades\Facade;

/**
 * @method static createEndpoints(array $iccids, $find, $retailer)
 * @method static getAvailableSims()
 * @method static getEndpoint(mixed $bics_id)
 * @method static getSim(mixed $iccid)
 * @method static createEndpointWithBenefits($find, $find1, )
 * @method static getDestinationBasedOnPlan($plan)
 * @method static createDestinationBasedOnPlan($plan)
 */
class Bics extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'bics';
    }
}
