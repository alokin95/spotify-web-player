<?php


namespace App\Repository\Spotify;


interface SpotifyTrackRepositoryInterface extends BaseSpotifyInterface
{
    public function removeOldTracks();
}
