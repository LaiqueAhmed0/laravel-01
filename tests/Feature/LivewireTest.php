<?php

use App\Livewire\BenefitCreate;
use App\Livewire\Catalog;
use App\Livewire\CustomPlanBuilder;
use App\Livewire\Dashboard\Breakdown;
use App\Livewire\Dashboard\User\LiveData;
use App\Livewire\EndpointAddBenefit;
use App\Livewire\EndpointCreate;
use App\Livewire\EndpointDelete;
use App\Livewire\EndpointRemoveBenefit;
use App\Livewire\PricingForm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('benefit create', function () {
    $component = Livewire::test(BenefitCreate::class);

    $component->assertStatus(200);
});

test('catalog', function () {
    $user = User::factory(['group' => 3])->create();

    $component = Livewire::actingAs($user)->test(Catalog::class);

    $component->assertStatus(200);
});

test('custom plan builder', function () {
    $user = User::factory(['group' => 3])->create();

    $component = Livewire::actingAs($user)->test(CustomPlanBuilder::class);

    $component->assertStatus(200);
});

test('endpoint add benefit', function () {
    $component = Livewire::test(EndpointAddBenefit::class);

    $component->assertStatus(200);
});

test('endpoint create', function () {
    $component = Livewire::test(EndpointCreate::class);

    $component->assertStatus(200);
});

test('endpoint delete', function () {
    $component = Livewire::test(EndpointDelete::class);

    $component->assertStatus(200);
});

test('endpoint remove benefit', function () {
    $component = Livewire::test(EndpointRemoveBenefit::class);

    $component->assertStatus(200);
});

test('pricing form', function () {
    $component = Livewire::test(PricingForm::class);

    $component->assertStatus(200);
});

test('dashboard breakdown', function () {
    $component = Livewire::test(Breakdown::class);

    $component->assertStatus(200);
});

test('dashboard user live data', function () {
    $component = Livewire::test(LiveData::class);

    $component->assertStatus(200);
});
