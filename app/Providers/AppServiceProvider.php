<?php

namespace App\Providers;

use App\Bics\Bics;
use App\Bics\Import;
use App\Square;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('bics_import', function () {
            return new Import();
        });

        $this->app->singleton(Bics::class, fn () => new Bics(
            username: config('system.bics.username'),
            password: config('system.bics.password'),
        ));
        $this->app->alias(Bics::class, 'bics');

        $this->app->bind('square', function () {
            return new Square();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
