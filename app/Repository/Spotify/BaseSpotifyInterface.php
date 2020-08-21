<?php


namespace App\Repository\Spotify;


interface BaseSpotifyInterface
{
    public function save(object $object);
    public function get();
}
