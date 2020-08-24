<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::namespace('Auth')->group(function(){
    Route::get('spotify/authenticate', 'SpotifyAuthController@authenticate');
    Route::get('spotify/callback', 'SpotifyAuthController@callback');
    Route::get('spotify/token/refresh', 'SpotifyAuthController@refreshToken');
    Route::get('spotify/user', 'SpotifyAuthController@user');
    Route::post('spotify/revoke', 'SpotifyAuthController@revokeAccess');
});

Route::get('/spotify/popular', 'SpotifyController@getArtistsAndTracks');
Route::post('/spotify/play', 'SpotifyController@play');
Route::post('/spotify/device', 'SpotifyController@switchDevice');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
