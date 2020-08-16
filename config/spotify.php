<?php

return [
    'client_id' => env("SPOTIFY_CLIENT_ID"),

    'client_secret' => env("SPOTIFY_CLIENT_SECRET"),

    'redirect_url' => 'http://spotify.loc/api/spotify/callback',

    'response_type' => 'code',

    'scopes' => [
        'user-read-playback-state',
        'user-modify-playback-state',
        'user-read-currently-playing',
        'streaming app-remote-control',
        'user-top-read',
        'user-read-playback-position',
        'user-read-recently-played',
        'user-library-modify',
        'user-library-read',
        'playlist-read-collaborative',
        'playlist-modify-public',
        'playlist-read-private',
        'playlist-modify-private'
    ],
];
