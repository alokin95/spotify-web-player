<?php


namespace App\Repository\Spotify;


use Illuminate\Support\Facades\Redis;

class SpotifyTrackRepository implements SpotifyTrackRepositoryInterface
{

    public function save(object $object)
    {
        Redis::sadd('spotify:tracks', json_encode($object));
    }
}
