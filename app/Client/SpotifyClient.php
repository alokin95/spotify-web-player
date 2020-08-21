<?php


namespace App\Client;


use App\Repository\Spotify\SpotifyArtistRepositoryInterface;
use App\Repository\Spotify\SpotifyTrackRepositoryInterface;
use App\Repository\Token\TokenRepositoryInterface;
use Illuminate\Support\Facades\Http;

class SpotifyClient
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

    public function authorize()
    {
        $client_id = config("spotify.client_id");
        $redirect_uri = config('spotify.redirect_url');
        $response_type = config('spotify.response_type');
        $scopes = implode(" ", config('spotify.scopes'));

        $url = "https://accounts.spotify.com/authorize?client_id=$client_id&response_type=$response_type&redirect_uri=$redirect_uri&scope=$scopes";

        return redirect()->away($url);
    }

    public function getAccessToken()
    {
        $response = Http::asForm()->post('https://accounts.spotify.com/api/token', [
            'grant_type'        => 'authorization_code',
            'code'              => request()->get('code'),
            'redirect_uri'      => config('spotify.redirect_url'),
            'client_id'         => config('spotify.client_id'),
            'client_secret'     => config('spotify.client_secret')
        ]);

        return \GuzzleHttp\json_decode($response);
    }

    public function refreshToken()
    {
        $encodedKeys = base64_encode(config('spotify.client_id') . ":" . config('spotify.client_secret'));
        $refreshToken = $this->tokenRepository->getRefreshToken('spotify');

        $response = Http::withHeaders(["Authorization" => "Basic $encodedKeys" ])->asForm()->post('https://accounts.spotify.com/api/token', [
            'grant_type'        => 'refresh_token',
            'refresh_token'     => $refreshToken
        ]);

        return \GuzzleHttp\json_decode($response);
    }

    public function getUserData()
    {
        $accessToken = $this->tokenRepository->getAccessToken('spotify');
        $response = Http::withHeaders(["Authorization" => "Bearer " . $accessToken])->get('https://api.spotify.com/v1/me');

        return $response->json();
    }

    public function getMostListened(string $type = 'artists')
    {
        $this->spotifyArtistRepository->removeOldArtists();
        $this->spotifyTrackRepository->removeOldTracks();

        $accessToken = $this->tokenRepository->getAccessToken('spotify');
        $response = Http::withHeaders(["Authorization" => "Bearer $accessToken"])->get("https://api.spotify.com/v1/me/top/$type?time_range=short_term&limit=5");

        return \GuzzleHttp\json_decode($response);

    }
}
