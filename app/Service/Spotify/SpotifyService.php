<?php

namespace App\Service\Spotify;


use App\Repository\Token\TokenRepositoryInterface;

class SpotifyService
{
    /**
     * @var TokenRepositoryInterface
     */
    private $tokenRepository;

    public function __construct(TokenRepositoryInterface $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    public function getAccessToken()
    {
        return $this->tokenRepository->getAccessToken('spotify');
    }
}
