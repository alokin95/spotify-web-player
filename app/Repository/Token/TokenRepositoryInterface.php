<?php


namespace App\Repository\Token;


interface TokenRepositoryInterface
{
    public function save(string $provider, array $data);
    public function getAccessToken(string $provider);
    public function getRefreshToken(string $provider);
    public function remove(string $provider);
    public function getTokenTTL(string $provider, string $token);
}
