<?php

namespace App\Bics;

use App\Models\Volume;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpZip\ZipFile;

class Import
{
    public function unZip()
    {
        $files = Storage::disk('data_stream')->files();

        foreach ($files as $file) {
            if (str_contains($file, 'mobility')) {
                continue;
            }

            try {
                $zip = new ZipFile();
                $zip->openFile(base_path('data_stream/'.$file));
                $txtFiles = $zip->getListFiles();

                foreach ($txtFiles as $txtFile) {
                    if (! $zip->hasEntry($txtFile)) {
                        continue;
                    }
                    $data = explode("\n", $zip->getEntryContents($txtFile));
                    foreach ($data as $key => $item) {
                        $row = explode(';', $item);

                        if (! ($key != 0 && isset($row[1]) && $row[1] != '')) {
                            continue;
                        }
                        if (! isset($row[8]) || $row[8] == '' || ! isset($row[14]) || $row[14] == '') {
                            continue;
                        }

                        $date = Carbon::createFromFormat('d/m/Y H:i:s', $row[1]);

                        $params = [
                            'iccid' => $row[14],
                            'bics_plan_id' => $row[7],
                            'operator' => $row[21],
                            'endpoint' => $row[22],
                            'date' => $date->format('Y-m-d'),
                            'country' => $row[13],
                            'volume' => abs((int) $row[8]),
                            'timestamp' => $row[2],
                        ];

                        $vol = Volume::firstOrCreate($params);
                    }
                    Storage::disk('data_stream')->move($file, 'imported/'.$file);
                }
            } catch (\Exception $exception) {
                //                Log::alert('Error with zip');
            }
        }
    }
}
