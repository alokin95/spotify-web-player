<?php


namespace App\Repository;


interface TokenRepositoryInterface
{
    public function save(string $provider, array $data);
    public function getAccessToken(string $provider);
    public function remove(string $provider);
}
