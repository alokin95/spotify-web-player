<?php


namespace App\Repository\Spotify;


interface SpotifyUserRepositoryInterface extends BaseSpotifyInterface
{
    public function getAuthenticatedUser();
}
