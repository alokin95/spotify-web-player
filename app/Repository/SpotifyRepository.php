<?php


namespace App\Repository;


use App\Client\SpotifyClient;
use Illuminate\Support\Facades\Redis;

class SpotifyRepository implements SpotifyRepositoryInterface
{
    /**
     * @var SpotifyClient
     */
    private $spotifyClient;

    public function __construct(SpotifyClient $spotifyClient)
    {
        $this->spotifyClient = $spotifyClient;
    }

    public function getAuthenticatedUser()
    {
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            return false;
        }

        if (!$this->getUserFromRedis()){
            $user = $this->spotifyClient->getUserData();
            $this->saveUser($user);
        }

        return $this->getUserFromRedis();
    }

    private function getAccessToken()
    {
        return Redis::get('spotify:access_token');
    }

    private function saveUser($user)
    {
        Redis::hset('spotify:user', 'display_name', $user['display_name']);
        Redis::hset('spotify:user', 'profile_link', $user['external_urls']['spotify']);

        return Redis::hgetall('spotify:user');
    }

    private function getUserFromRedis()
    {
        return Redis::hgetall('spotify:user');
    }
}
