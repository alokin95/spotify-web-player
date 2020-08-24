<?php

namespace App\Service\Spotify;


use App\Client\SpotifyClient;
use App\Repository\Spotify\SpotifyArtistRepositoryInterface;
use App\Repository\Spotify\SpotifyTrackRepositoryInterface;
use App\Repository\Token\TokenRepositoryInterface;

class SpotifyService
{
    /**
     * @var TokenRepositoryInterface
     */
    private $tokenRepository;
    /**
     * @var SpotifyTrackRepositoryInterface
     */
    private $spotifyTrackRepository;
    /**
     * @var SpotifyArtistRepositoryInterface
     */
    private $spotifyArtistRepository;
    /**
     * @var SpotifyClient
     */
    private $spotifyClient;

    public function __construct(
        TokenRepositoryInterface $tokenRepository,
        SpotifyTrackRepositoryInterface $spotifyTrackRepository,
        SpotifyArtistRepositoryInterface $spotifyArtistRepository,
        SpotifyClient $spotifyClient)
    {
        $this->tokenRepository = $tokenRepository;
        $this->spotifyTrackRepository = $spotifyTrackRepository;
        $this->spotifyArtistRepository = $spotifyArtistRepository;
        $this->spotifyClient = $spotifyClient;
    }

    public function getAccessToken()
    {
        return $this->tokenRepository->getAccessToken('spotify');
    }

    public function getPopularArtistsAndTracksFromRepository()
    {
        $data['tracks'] = $this->spotifyTrackRepository->get();
        $data['artists'] = $this->spotifyArtistRepository->get();

        return $data;
    }

    public function playUri()
    {
        $uri = request()->uri;
        $deviceId = request()->deviceId;

        $this->spotifyClient->playUri($uri, $deviceId);
    }

    public function switchDevice()
    {
        return $this->spotifyClient->switchDevice();
    }

    public function pause()
    {
        return $this->spotifyClient->pausePlayback();
    }
}
