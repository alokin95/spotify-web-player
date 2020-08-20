<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Service\Spotify\SpotifyAuthService;
use App\Service\Spotify\SpotifyService;
use Illuminate\Http\Request;

class SpotifyAuthController extends Controller
{
    /** @var SpotifyAuthService $spotifyAuthService */
    private $spotifyAuthService;
    /**
     * @var SpotifyService
     */
    private $spotifyService;

    public function __construct(SpotifyAuthService $spotifyAuthService, SpotifyService $spotifyService)
    {
        $this->spotifyAuthService = $spotifyAuthService;
        $this->spotifyService = $spotifyService;
    }

    public function authenticate()
    {
        return $this->spotifyAuthService->authorize();
    }

    public function callback()
    {
        $this->spotifyAuthService->getAccessToken();
        return redirect('/');
    }

    public function user()
    {
        $user = $this->spotifyAuthService->getUserInfo();
        if ($user)
        {
            $user['access_token'] = $this->spotifyService->getAccessToken();
        }

        return response()->json([
            'user' => $user
        ]);
    }

    public function revokeAccess()
    {
        $this->spotifyAuthService->revokeAccess();
    }
}
