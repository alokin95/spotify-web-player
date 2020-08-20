<?php


namespace App\Service\Spotify;


use App\Entity\Spotify\Track;

class TrackCreationService
{
    /**
     * @var Track
     */
    private $track;

    public function __construct(Track $track)
    {

        $this->track = $track;
    }

    public function create($track)
    {
        $this->track->setName($track->name);
        $this->track->setImage($track->album->images[1]);
        $this->track->setArtistUri($track->artists[0]->uri);
        $this->track->setArtistName($track->artists[0]->name);
        $this->track->setArtistUrl($track->album->artists[0]->external_urls->spotify);
        $this->track->setTrackUrl($track->external_urls->spotify);
        $this->track->setTrackUri($track->uri);

        return $this->track;
    }
}
