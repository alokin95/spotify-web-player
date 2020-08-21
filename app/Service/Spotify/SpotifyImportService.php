<?php


namespace App\Service\Spotify;


use App\Client\SpotifyClient;
use App\Repository\Spotify\SpotifyArtistRepositoryInterface;
use App\Repository\Spotify\SpotifyTrackRepositoryInterface;
use App\Repository\Token\TokenRepositoryInterface;

class SpotifyImportService
{
    /**
     * @var SpotifyClient
     */
    private $spotifyClient;
    /**
     * @var SpotifyTrackRepositoryInterface
     */
    private $spotifyTrackRepository;
    /**
     * @var SpotifyArtistRepositoryInterface
     */
    private $spotifyArtistRepository;
    /**
     * @var TrackCreationService
     */
    private $trackCreationService;
    /**
     * @var ArtistCreationService
     */
    private $artistCreationService;
    /**
     * @var TokenRepositoryInterface
     */
    private $tokenRepository;

    public function __construct
    (SpotifyClient $spotifyClient,
     SpotifyTrackRepositoryInterface $spotifyTrackRepository,
     SpotifyArtistRepositoryInterface $spotifyArtistRepository,
     TrackCreationService $trackCreationService,
     ArtistCreationService $artistCreationService,
     TokenRepositoryInterface $tokenRepository
    )
    {
        $this->spotifyClient = $spotifyClient;
        $this->spotifyTrackRepository = $spotifyTrackRepository;
        $this->spotifyArtistRepository = $spotifyArtistRepository;
        $this->trackCreationService = $trackCreationService;
        $this->artistCreationService = $artistCreationService;
        $this->tokenRepository = $tokenRepository;
    }

    public function importUsersMostListened()
    {

        if (!$this->tokenRepository->getAccessToken('spotify'))
        {
            return false;
        }

        $artists = $this->spotifyClient->getMostListened('artists');
        $tracks = $this->spotifyClient->getMostListened('tracks');

        foreach ($artists->items as $artist)
        {
            $artist = $this->artistCreationService->create($artist);
            $this->spotifyArtistRepository->save($artist);
        }

        foreach ($tracks->items as $track)
        {
            $track = $this->trackCreationService->create($track);
            $this->spotifyTrackRepository->save($track);
        }
    }
}
