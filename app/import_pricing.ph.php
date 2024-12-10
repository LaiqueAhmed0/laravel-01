<?php

$file = \Illuminate\Support\Facades\Storage::get('pricing_new.csv');
$data = [];
foreach (str_getcsv($file, "\n") as $row) {
    $data[] = str_getcsv($row);
}
unset($data[0]);
foreach ($data as $item) {
    if ($item[2] == 'Saint Martin (French part)') {
        $item[2] = 'Saint Martin';
    }

    if ($item[2] == 'Russian Federation') {
        $item[2] = 'Russia';
    }

    if ($item[2] == 'South Korea (the Republic of)') {
        $item[2] = 'South Korea';
    }

    if ($item[2] == "Lao People's Democratic Republic") {
        $item[2] = 'Laos';
    }
    if ($item[2] == 'Viet Nam') {
        $item[2] = 'Vietnam';
    }
    if ($item[2] == 'Syrian Arab Republic') {
        $item[2] = 'Syria';
    }
    if ($item[2] == 'Micronesia (Federated States of)') {
        $item[2] = 'Micronesia';
    }

    if ($item[2] == 'Congo (the Democratic Republic)') {
        $item[2] = 'Democratic Republic Of The Congo';
    }

    if ($item[2] == "Cote d'Ivoire") {
        $item[2] = 'Ivory Coast';
    }

    if ($item[2] == 'United States of America') {
        $item[2] = 'United States';
    }

    if ($item[2] == 'Virgin Islands (U.S.)') {
        $item[2] = 'United States Virgin Islands';
    }

    $country = Country::where('name', $item[2])->first();
    if (! $country) {
        dd($item);
    }

    if (str_contains($item[3], ',')) {
        $item[3] = str_replace(',', '', $item[3]);
        $item[3] = $item[3] / 1000;
    }

    $country->active = 1;
    $country->price_per_mb = str_replace(',', '.', $item[3]);
    $country->save();
}
