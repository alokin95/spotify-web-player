<?php


namespace App\Entity\Spotify;


class Track implements \JsonSerializable
{
    private $artistUrl;
    private $artistName;
    private $artistUri;
    private $trackUrl;
    private $image;
    private $trackUri;
    private $name;

    /**
     * @return mixed
     */
    public function getArtistUrl()
    {
        return $this->artistUrl;
    }

    /**
     * @param mixed $artistUrl
     */
    public function setArtistUrl($artistUrl): void
    {
        $this->artistUrl = $artistUrl;
    }

    /**
     * @return mixed
     */
    public function getArtistName()
    {
        return $this->artistName;
    }

    /**
     * @param mixed $artistName
     */
    public function setArtistName($artistName): void
    {
        $this->artistName = $artistName;
    }

    /**
     * @return mixed
     */
    public function getArtistUri()
    {
        return $this->artistUri;
    }

    /**
     * @param mixed $artistUri
     */
    public function setArtistUri($artistUri): void
    {
        $this->artistUri = $artistUri;
    }

    /**
     * @return mixed
     */
    public function getTrackUrl()
    {
        return $this->trackUrl;
    }

    /**
     * @param mixed $trackUrl
     */
    public function setTrackUrl($trackUrl): void
    {
        $this->trackUrl = $trackUrl;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getTrackUri()
    {
        return $this->trackUri;
    }

    /**
     * @param mixed $trackUri
     */
    public function setTrackUri($trackUri): void
    {
        $this->trackUri = $trackUri;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }


    public function jsonSerialize()
    {
        return [
            'name'          => $this->name,
            'image'         => $this->image,
            'artistUri'     => $this->artistUri,
            'artistName'    => $this->artistName,
            'artistUrl'     => $this->artistUrl,
            'trackUrl'      => $this->trackUrl,
            'trackUri'      => $this->artistUri
        ];
    }
}
