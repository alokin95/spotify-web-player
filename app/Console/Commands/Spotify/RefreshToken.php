<?php

namespace App\Console\Commands\Spotify;

use App\Service\Spotify\SpotifyAuthService;
use Illuminate\Console\Command;

class RefreshToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spotify:refreshtoken';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the new access token from the Spotify API';
    /**
     * @var SpotifyAuthService
     */
    private $spotifyAuthService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SpotifyAuthService $spotifyAuthService)
    {
        parent::__construct();
        $this->spotifyAuthService = $spotifyAuthService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->spotifyAuthService->refreshToken();
    }
}
