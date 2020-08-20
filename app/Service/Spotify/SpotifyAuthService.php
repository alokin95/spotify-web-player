<?php

namespace App\Service\Spotify;


use App\Client\SpotifyClient;
use App\Repository\Spotify\SpotifyUserRepositoryInterface;
use App\Repository\Token\TokenRepositoryInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class SpotifyAuthService
{
    /**
     * @var SpotifyClient
     */
    private $spotifyClient;
    /**
     * @var TokenRepositoryInterface
     */
    private $tokenRepository;
    /**
     * @var SpotifyUserRepositoryInterface
     */
    private $spotifyRepository;

    public function __construct(SpotifyClient $spotifyClient, TokenRepositoryInterface $tokenRepository, SpotifyUserRepositoryInterface $spotifyRepository)
    {
        $this->spotifyClient = $spotifyClient;
        $this->tokenRepository = $tokenRepository;
        $this->spotifyRepository = $spotifyRepository;
    }

    public function authorize()
    {
        return $this->spotifyClient->authorize();
    }

    public function getAccessToken()
    {
        if (request()->has('error'))
        {
            return redirect('/');
        }

        $response = $this->spotifyClient->getAccessToken();

        return $this->tokenRepository->save('spotify', $response);
    }

    public function getUserInfo()
    {
        $user = $this->spotifyRepository->getAuthenticatedUser();

        if (!$user) {
            return false;
        }

        return $user;
    }

    public function revokeAccess()
    {
        $this->tokenRepository->remove('spotify');
    }

    public function refreshToken()
    {
        if ($this->tokenRepository->getRefreshToken('spotify'))
        {
            $accessTokenTTL = $this->tokenRepository->getTokenTTL('spotify', 'access_token');

            if ($accessTokenTTL < 420)
            {
                $response = $this->spotifyClient->refreshToken();
                $this->tokenRepository->save('spotify', $response);
            }
        }
    }
}
