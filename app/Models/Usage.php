<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;

class Usage extends Model
{
    protected $guarded = [];

    public static function chart($volumes, array $dates, string $type = 'days')
    {
        if (! $dates) {
            return;
        }
        $from = $dates[0];
        $to = $dates[1];

        if (count($volumes)) {
            $period = CarbonPeriod::create($from, '1 day', $to);

            $dates = [];
            foreach ($period as $date) {
                $dates[$date->format('j M')] = 0;
            }

            foreach ($volumes as $volume) {
                $date = Carbon::createFromFormat('d/m/Y', $volume->date);
                if (isset($dates[$date->format('j M')])) {
                    $dates[$date->format('j M')] += round(str_replace(',', '', $volume->volume_formatted), 2);
                } else {
                    $dates[$date->format('j M')] = round(str_replace(',', '', $volume->volume_formatted), 2);
                }
            }

            foreach ($dates as $day => $value) {
                $dates[$day] = (string) $value;
            }

            $data['labels'] = array_keys($dates);
            $data['data'] = array_values($dates);

            return $data;
        }

        return [
            'labels' => null,
            'data' => null,
        ];
    }

    public static function getTotal(int $id, string $from, string $to)
    {
        $total = 0;
        $usages = Usage::where('piccid', $id)->whereBetween('date', [
            $from,
            $to,
        ])->get();
        foreach ($usages as $usage) {
            $total += $usage->bytes;
        }

        return $total;
    }

    public static function userTable(int $subId, $from, $to)
    {
        $usages =
            Usage::where('piccid', $subId)->whereBetween('date', [
                $from,
                $to,
            ])->orderby('date', 'ASC');
        $data = [];
        if (! $usages->exists()) {
            return array_reverse($data);
        }
        foreach ($usages->get() as $usage) {
            $array = [
                $usage->date,
                $usage->bytes,
                $usage->country,
                $usage->carrier,
            ];
            $splice = false;
            for ($i = 0; $i < count($data); $i++) {
                if (array_search($usage->date, $data[$i]) !== 0) {
                    continue;
                }
                if ($data[$i][2] == $array[2] && $data[$i][0] == $array[0]) {
                    $data[$i][1] += $array[1];
                    $splice = true;
                    break;
                }
                if ($i != 0 && $data[$i][2] == $data[$i - 1][2]) {
                    $data[] = $array;
                    $splice = true;
                    break;
                }
                $data[] = $data[$i];
                $data[$i] = $array;
                $splice = true;
                break;
            }
            if (! $splice) {
                $data[] = $array;
            }
        }

        return array_reverse($data);
    }
}
