<?php

namespace App\Service\Spotify;


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

    public function __construct(
        TokenRepositoryInterface $tokenRepository,
        SpotifyTrackRepositoryInterface $spotifyTrackRepository,
        SpotifyArtistRepositoryInterface $spotifyArtistRepository)
    {
        $this->tokenRepository = $tokenRepository;
        $this->spotifyTrackRepository = $spotifyTrackRepository;
        $this->spotifyArtistRepository = $spotifyArtistRepository;
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
}
