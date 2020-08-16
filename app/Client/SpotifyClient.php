<?php


namespace App\Client;


use Illuminate\Support\Facades\Http;

class SpotifyClient
{

    public function authorize()
    {
        $client_id = config("spotify.client_id");
        $redirect_uri = config('spotify.redirect_url');
        $response_type = config('spotify.response_type');
        $scopes = implode(" ", config('spotify.scopes'));

        $url = "https://accounts.spotify.com/authorize?client_id=$client_id&response_type=$response_type&redirect_uri=$redirect_uri&scopes=$scopes";

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

}
