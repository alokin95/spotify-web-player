<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>

    <style>
        @import url("https://fonts.googleapis.com/css?family=Open+Sans");

        html {
            font-family: Arial;
            font-size: 16px;
            background: #5e42a6;
        }

        .sidebar {
            position: fixed;
            width: 25%;
            height: 100vh;
            background: #312450;
        }

        .nav {
            position: relative;
            margin: 0 15%;
            text-align: right;
            top: 50%;
            transform: translateY(-50%);
            font-weight: bold;
        }

        .nav ul {
            list-style: none;
        }

        .nav ul li {
            position: relative;
            margin: 3.2em 0;
        }

        .nav ul li a {
            line-height: 5em;
            text-transform: uppercase;
            text-decoration: none;
            letter-spacing: 0.4em;
            color: rgba(255, 255, 255, 0.35);
            display: block;
            transition: all ease-out 300ms;
        }

        .selected-link {
            color: white !important;
        }

        .nav ul li.active a {
            color: white;
        }

        .nav ul li:not(.active)::after {
            opacity: 0.2;
        }

        .nav ul li:not(.active):hover a {
            color: rgba(255, 255, 255, 0.75);
        }

        .nav ul li::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 0.2em;
            background: black;
            left: 0;
            bottom: 0;
            background-image: linear-gradient(to right, #5e42a6, #b74e91);
        }

        #music-player {
            position: relative;
            top: 10%;
            left: 15%;
        }

        .twitter {
            position: relative;
            width: 75%;
            float: right;
            padding-top: 200px;
        }

        .twitter .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .twitter a {
            position: relative;
        }

        .twitter a img {
            width: 48px;
            height: 48px;
        }

        .twitter p {
            text-transform: uppercase;
            font-size: 1em;
            letter-spacing: 0.1em;
            color: #FFF;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
    </head>
    <body>
        <div id="app">

            <main class="main">
                <aside class="sidebar">
                    <div id="music-player">
                        <music-player></music-player>
                    </div>
                    <nav class="nav">
                        <ul>
                            <li><router-link to="/" exact>Spotify</router-link></li>
                            <li><router-link to="/sports" >Sports</router-link></li>
                            <li><router-link to="/settings" >Settings</router-link></li>
                        </ul>
                    </nav>
                </aside>

                <section class="twitter">
                    <div class="container">
                        <router-view></router-view>
                </section>
            </main>
        </div>

        <script>


        </script>
    <script src="https://sdk.scdn.co/spotify-player.js"></script>
    <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
