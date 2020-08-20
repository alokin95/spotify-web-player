<?php

namespace App\Console\Commands\Spotify;

use App\Service\Spotify\SpotifyImportService;
use Illuminate\Console\Command;

class ImportMostListened extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spotify:mostlistened';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the most listened artists/tracks for the current user';
    /**
     * @var SpotifyImportService
     */
    private $spotifyImportService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SpotifyImportService $spotifyImportService)
    {
        parent::__construct();
        $this->spotifyImportService = $spotifyImportService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->spotifyImportService->importUsersMostListened();
            echo "Success\n";
        }
        catch (\Exception $e)
        {
            echo $e->getMessage();
        }
    }
}
