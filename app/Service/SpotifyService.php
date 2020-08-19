<?php

namespace App\Service;


use App\Repository\TokenRepositoryInterface;

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
