<?php

namespace App\Http\Controllers;

use App\Service\SpotifyAuthService;
use Illuminate\Http\Request;

class SpotifyAuthController extends Controller
{
    /** @var SpotifyAuthService $spotifyAuthService */
    private $spotifyAuthService;

    public function __construct(SpotifyAuthService $spotifyAuthService)
    {
        $this->spotifyAuthService = $spotifyAuthService;
    }

    public function authenticate()
    {
        return $this->spotifyAuthService->authorize();
    }

    public function callback()
    {
        return $this->spotifyAuthService->getAccessToken();
    }
}
