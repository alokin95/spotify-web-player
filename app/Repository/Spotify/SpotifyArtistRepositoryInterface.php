<?php


namespace App\Repository\Spotify;


interface SpotifyArtistRepositoryInterface extends BaseSpotifyInterface
{
    public function removeOldArtists();
}
