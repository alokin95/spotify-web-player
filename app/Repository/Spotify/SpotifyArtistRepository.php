<?php


namespace App\Repository\Spotify;


use Illuminate\Support\Facades\Redis;

class SpotifyArtistRepository implements SpotifyArtistRepositoryInterface
{

    public function save(object $object)
    {
        Redis::sadd('spotify:artists', json_encode($object));
    }

    public function get()
    {
        $artists = Redis::smembers("spotify:artists");

        $responseArtists = [];

        foreach ($artists as $artist)
        {
            $responseArtists[] = json_decode($artist);
        }

        return $responseArtists;
    }
}
