<?php

namespace App\Providers;

use App\Repository\SpotifyRepository;
use App\Repository\SpotifyRepositoryInterface;
use App\Repository\TokenRepository;
use App\Repository\TokenRepositoryInterface;
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
        $this->app->bind(
            TokenRepositoryInterface::class,
            TokenRepository::class
        );
        $this->app->bind(
            SpotifyRepositoryInterface::class,
            SpotifyRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
