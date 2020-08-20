<?php

namespace App\Providers;

use App\Repository\Spotify\SpotifyArtistRepository;
use App\Repository\Spotify\SpotifyArtistRepositoryInterface;
use App\Repository\Spotify\SpotifyTrackRepository;
use App\Repository\Spotify\SpotifyTrackRepositoryInterface;
use App\Repository\Spotify\SpotifyUserRepository;
use App\Repository\Spotify\SpotifyUserRepositoryInterface;
use App\Repository\Token\TokenRepository;
use App\Repository\Token\TokenRepositoryInterface;
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
            SpotifyUserRepositoryInterface::class,
            SpotifyUserRepository::class
        );
        $this->app->bind(
            SpotifyTrackRepositoryInterface::class,
            SpotifyTrackRepository::class
        );
        $this->app->bind(
            SpotifyArtistRepositoryInterface::class,
            SpotifyArtistRepository::class
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
