<?php


namespace App\Repository\Token;


use Illuminate\Support\Facades\Redis;

class TokenRepository implements TokenRepositoryInterface
{
    public function save($provider, $data)
    {
        $data = json_decode(json_encode($data), true);

        if (!array_key_exists('expires_in', $data))
        {
            $data['expires_in'] = 3600;
        }

        try {
            foreach ($data as $key => $value)
            {
                Redis::set($provider . ':' . $key, $value);
                if ($key != 'refresh_token') {
                    Redis::expire($provider . ':' . $key, $data['expires_in']);
                }
            }

            return true;
        }
        catch (\Exception $exception)
        {
            return $exception->getMessage();
        }
    }

    public function getAccessToken(string $provider)
    {
        return Redis::get($provider . ':access_token');
    }


    public function remove(string $provider) : void
    {
        $spotifyKeys = Redis::keys($provider . '*');

        foreach ($spotifyKeys as $redisKey)
        {
            Redis::del($redisKey);
        }

    }

    public function getRefreshToken(string $provider)
    {
        return Redis::get($provider . ':refresh_token');
    }

    public function getTokenTTL(string $provider, string $token)
    {
        return Redis::ttl($provider . ":" . $token);
    }
}
