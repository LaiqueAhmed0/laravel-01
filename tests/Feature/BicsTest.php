<?php

use App\Bics\Bics;
use Illuminate\Support\Facades\Http;

test('authorizes on creation', function () {
    useFakeBicsRequests();

    $bics = new Bics('username', 'password');

    Http::assertSent(function ($request) {
        return $request->url() === 'https://sft.bics.com/api/login' && $request->method() === 'POST';
    });
});

test('get sim', function () {
    useFakeBicsRequests([
        '*' => Http::response([
            'Response' => 'res',
        ]),
    ]);

    $bics = new Bics('username', 'password');

    Http::assertSent(function ($request) {
        return $request->url() === 'https://sft.bics.com/api/login' && $request->method() === 'POST';
    });

    expect($bics->getSim('iccid'))->toBe('res');

    Http::assertSent(function ($request) {
        return $request->url() === 'https://sft.bics.com/api/fetchSIM?iccid=iccid' && $request->method() === 'GET';
    });
});

function useFakeBicsRequests(array $urls = [])
{
    $urls = array_merge(['login' => Http::response(['AccessToken' => '123', 'RefreshToken' => '456'])], $urls);

    $urls = collect($urls)
        ->mapWithKeys(fn ($response, $urlKey) => ["https://sft.bics.com/api/$urlKey" => $response])
        ->all();

    return Http::fake($urls);
}
