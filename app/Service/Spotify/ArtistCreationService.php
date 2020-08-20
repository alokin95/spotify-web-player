<?php


namespace App\Service\Spotify;


use App\Entity\Spotify\Artist;

class ArtistCreationService
{
    /**
     * @var Artist
     */
    private $artist;

    public function __construct(Artist $artist)
    {

        $this->artist = $artist;
    }

    public function create($artist)
    {
        $this->artist->setGenres($artist->genres);
        $this->artist->setImage($artist->images[1]);
        $this->artist->setUri($artist->uri);
        $this->artist->setUrl($artist->external_urls->spotify);
        $this->artist->setName($artist->name);

        return $this->artist;
    }
}
