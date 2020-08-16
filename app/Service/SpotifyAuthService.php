<?php

namespace App\Service;


use App\Client\SpotifyClient;
use Illuminate\Support\Facades\Http;

class SpotifyAuthService
{
    /**
     * @var SpotifyClient
     */
    private $spotifyClient;

    public function __construct(SpotifyClient $spotifyClient)
    {
        $this->spotifyClient = $spotifyClient;
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

        dd($response);
    }
}
