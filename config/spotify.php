<?php

return [
    'client_id' => env("SPOTIFY_CLIENT_ID"),

    'client_secret' => env("SPOTIFY_CLIENT_SECRET"),

    'redirect_url' => 'http://spotify.loc/api/spotify/callback',

    'response_type' => 'code',

    'scopes' => [
        //Spotify connect
        'user-read-playback-state',
        'user-modify-playback-state',
        'user-read-currently-playing',

        //Listening History
        'user-top-read',
        'user-read-playback-position',
        'user-read-recently-played',

        //Library
        'user-library-modify',
        'user-library-read',

        //Playlists
        'playlist-read-collaborative',
        'playlist-modify-public',
        'playlist-read-private',
        'playlist-modify-private',

        //Playback
        'streaming',
        'app-remote-control',

        //Users
        'user-read-email',
        'user-read-private'
    ],
];
