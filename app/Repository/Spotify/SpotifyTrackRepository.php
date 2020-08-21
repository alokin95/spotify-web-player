<?php

namespace App\Repository\Spotify;

use Illuminate\Support\Facades\Redis;

class SpotifyTrackRepository implements SpotifyTrackRepositoryInterface
{

    public function save(object $object)
    {
        Redis::sadd('spotify:tracks', json_encode($object));
    }

    public function get()
    {
        $tracks = Redis::smembers('spotify:tracks');

        $responseTracks = [];
        foreach ($tracks as $track)
        {
            $responseTracks[] = json_decode($track);
        }

        return $responseTracks;
    }

    public function removeOldTracks()
    {
        return Redis::del('spotify:tracks');
    }
}
