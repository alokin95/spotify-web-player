<?php


namespace App\Repository\Spotify;


use Illuminate\Support\Facades\Redis;

class SpotifyArtistRepository implements SpotifyArtistRepositoryInterface
{

    public function save(object $object)
    {
        Redis::sadd('spotify:artists', json_encode($object));
    }
}
