<?php

namespace App\Http\Controllers;

use App\Service\Spotify\SpotifyService;
use Illuminate\Http\Request;

class SpotifyController extends Controller
{
    /**
     * @var SpotifyService
     */
    private $spotifyService;

    public function __construct(SpotifyService $spotifyService)
    {

        $this->spotifyService = $spotifyService;
    }

    public function getArtistsAndTracks()
    {
        $response = $this->spotifyService->getPopularArtistsAndTracksFromRepository();

        return response()->json([
           'artists'    => $response['artists'],
           'tracks'     => $response['tracks']
        ]);
    }

    public function play()
    {
        $this->spotifyService->playUri();
    }
}
