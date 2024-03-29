<template>
    <div class="player">
        <div id="control-panel" class="control-panel">
            <div class="album-art">
                <img v-bind:class="{'track-album-cover-spinning': playing}" v-show="trackLoaded" :src="trackLoaded ? currentTrack.track_window.current_track.album.images[2].url : ''">
            </div>
            <div class="controls">
                <div class="prev"></div>
                <div id="play" class="play" @click="switchDevice"></div>
                <div class="next" @click="initializeSpotifyObject"></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

    data() {
        return {
            user: {},
            player: {},
            currentTrack: {},
            trackLoaded: false,
            playing: false
        }
    },

    mounted() {
        this.getAuthenticatedUser();
        this.initializeSpotifyObject()
            .then(() => {
                this.initializeSpotifyPlayer();
            })
                .then(() => {
                    this.addPlayerListeners()
                });
    },

    methods: {

        switchDevice() {
            let deviceId = window.SpotifyPlayerId;

            if (!this.playing) {
                axios.post('api/spotify/device', {
                    deviceId,
                });

                this.playing = true;
                this.trackLoaded = true;
                return true;
            }

            axios.post('api/spotify/pause', {
                deviceId
            });
        },

        getAuthenticatedUser() {
            var self = this;
            axios.get('api/spotify/user')
                .then(function (response){
                    if (response.data.user){
                        $cookies.set('spotify-user', response.data.user);
                        self.user = response.data.user;
                    }
                    else {
                        $cookies.remove('spotify-user');
                    }
                });
        },

        initializeSpotifyPlayer() {
            let self = this;
            return new Promise(resolve => {
                this.player = new window.Spotify.Player({
                    name: 'Web Browser Player',
                    getOAuthToken: cb => { cb(self.user['access_token']); }
                });

                resolve();
            })
        },

        initializeSpotifyObject() {
            return new Promise(resolve => {
                if (window.Spotify) {
                    resolve();
                } else {
                    window.onSpotifyWebPlaybackSDKReady = resolve;
                }
            });
        },

        addPlayerListeners() {
            let self = this;
            // Error handling
            this.player.addListener('initialization_error', ({ message }) => { console.error(message); });
            this.player.addListener('authentication_error', ({ message }) => { console.error(message); });
            this.player.addListener('account_error', ({ message }) => { console.error(message); });
            this.player.addListener('playback_error', ({ message }) => { console.error(message); });

            // Playback status updates
            this.player.addListener('player_state_changed', state => {
                console.log(state);
                if (state) {
                    self.currentTrack = state;
                    self.playing = !state.paused;
                    self.trackLoaded = true;
                }
                else {
                    self.currentTrack = {};
                    self.playing = false;
                    self.trackLoaded = false;
                }
            });

            // Ready
            this.player.addListener('ready', ({device_id}) => {
                window.SpotifyPlayerId = device_id;
            });

            // Not Ready
            this.player.addListener('not_ready', ({ device_id }) => {
                console.log('Device ID has gone offline', device_id);
            });

            // Connect to the player!
            this.player.connect();
        }
    }
}
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css?family=Fira+Sans");
html, body {
    position: relative;
    min-height: 100vh;
    background-color: #FFF0F5;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: "Fira Sans", Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

.track-album-cover-spinning {
    -webkit-animation:spin 4s linear infinite;
    -moz-animation:spin 4s linear infinite;
    animation:spin 4s linear infinite;
}
@-moz-keyframes spin { 100% { -moz-transform: rotate(360deg); } }
@-webkit-keyframes spin { 100% { -webkit-transform: rotate(360deg); } }
@keyframes spin { 100% { -webkit-transform: rotate(360deg); transform:rotate(360deg); } }

.album-art {
    overflow: hidden;
}

.album-art img {
    width: 80px;
    height: 80px;
}

.player {
    position: relative;
}
.player .info {
    position: absolute;
    height: 60px;
    top: 0;
    opacity: 0;
    left: 10px;
    right: 10px;
    background-color: rgba(255, 255, 255, 0.5);
    padding: 5px 15px 5px 110px;
    border-radius: 15px;
    transition: all .5s ease;
}
.player .info .artist,
.player .info .name {
    display: block;
}
.player .info .artist {
    color: #222;
    font-size: 16px;
    margin-bottom: 5px;
}
.player .info .name {
    color: #999;
    font-size: 12px;
    margin-bottom: 8px;
}
.player .info .progress-bar {
    background-color: #ddd;
    height: 2px;
    width: 100%;
    position: relative;
}
.player .info .progress-bar .bar {
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    background-color: red;
    width: 10%;
    transition: all .2s ease;
}
.player .info.active {
    top: -60px;
    opacity: 1;
    transition: all .5s ease;
}
.player .control-panel {
    position: relative;
    background-color: #fff;
    border-radius: 15px;
    width: 300px;
    height: 80px;
    z-index: 5;
}
.player .control-panel .album-art {
    background-color: beige;
    position: absolute;
    left: 20px;
    height: 80px;
    width: 80px;
    border-radius: 50%;
    box-shadow: 0px 0px 20px 5px rgba(0, 0, 0, 0);
    transform: scale(1);
    transition: all .5s ease;
}
.player .control-panel .album-art::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 15px;
    height: 15px;
    background-color: #fff;
    border-radius: 50%;
    z-index: 5;
    transform: translate(-50%, -50%);
    -webkit-transform: translate(-50%, -50%);
}
.player .control-panel .album-art::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: 50%;
    background-position: center;
    background-repeat: no-repeat;
    background-size: 80px;
}
.player .control-panel.active .album-art {
    box-shadow: 0px 0px 20px 5px rgba(0, 0, 0, 0.2);
    transform: scale(1.2);
    transition: all .5s ease;
}
.player .control-panel.active .album-art::before {
    animation: rotation 3s infinite linear;
    -webkit-animation: rotation 3s infinite linear;
    animation-fill-mode: forwards;
}
@keyframes rotation {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
.player .control-panel .controls {
    display: flex;
    justify-content: flex-end;
    height: 80px;
    padding: 0 15px;
}
.player .control-panel .controls .prev,
.player .control-panel .controls .play,
.player .control-panel .controls .next {
    width: 55px;
    height: auto;
    border-radius: 10px;
    background-position: center center;
    background-repeat: no-repeat;
    background-size: 20px;
    margin: 5px 0;
    background-color: #fff;
    cursor: pointer;
    transition: background-color .3s ease;
    -webkit-transition: background-color .3s ease;
}
.player .control-panel .controls .prev:hover,
.player .control-panel .controls .play:hover,
.player .control-panel .controls .next:hover {
    background-color: #eee;
    transition: background-color .3s ease;
    -webkit-transition: background-color .3s ease;
}
.player .control-panel .controls .prev {
    background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMS4xLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDI1MC40ODggMjUwLjQ4OCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjUwLjQ4OCAyNTAuNDg4OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjEyOHB4IiBoZWlnaHQ9IjEyOHB4Ij4KPGcgaWQ9IlByZXZpb3VzX3RyYWNrIj4KCTxwYXRoIHN0eWxlPSJmaWxsLXJ1bGU6ZXZlbm9kZDtjbGlwLXJ1bGU6ZXZlbm9kZDsiIGQ9Ik0yMzcuNDg0LDIyLjU4N2MtMy4yNjYsMC03LjU5MS0wLjQwMS0xMS4wNzIsMi4wMDVsLTkyLjI2NCw3Ny45MVYzNy4yNTIgICBjMC0yLjUwNywwLjA1Ny0xNC42NjYtMTMuMDA0LTE0LjY2NmMtMy4yNjUsMC03LjU5LTAuNDAxLTExLjA3MiwyLjAwNUw4LjEwNywxMTAuNjkzYy05LjY2OSw2LjY3NC03Ljk5NywxNC41NTEtNy45OTcsMTQuNTUxICAgcy0xLjY3MSw3Ljg3OCw3Ljk5NywxNC41NTFsMTAxLjk2NSw4Ni4xMDJjMy40ODIsMi40MDUsNy44MDcsMi4wMDQsMTEuMDcyLDIuMDA0YzEzLjA2MiwwLDEzLjAwNC0xMS43LDEzLjAwNC0xNC42NjZ2LTY1LjI0OSAgIGw5Mi4yNjQsNzcuOTExYzMuNDgyLDIuNDA1LDcuODA3LDIuMDA0LDExLjA3MiwyLjAwNGMxMy4wNjIsMCwxMy4wMDQtMTEuNywxMy4wMDQtMTQuNjY2VjM3LjI1MiAgIEMyNTAuNDg4LDM0Ljc0NiwyNTAuNTQ2LDIyLjU4NywyMzcuNDg0LDIyLjU4N3oiIGZpbGw9IiNjMmM2Y2YiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K);
}
.player .control-panel .controls .play {
    background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMS4xLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDIzMi4xNTMgMjMyLjE1MyIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjMyLjE1MyAyMzIuMTUzOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjEyOHB4IiBoZWlnaHQ9IjEyOHB4Ij4KPGcgaWQ9IlBsYXkiPgoJPHBhdGggc3R5bGU9ImZpbGwtcnVsZTpldmVub2RkO2NsaXAtcnVsZTpldmVub2RkOyIgZD0iTTIwMy43OTEsOTkuNjI4TDQ5LjMwNywyLjI5NGMtNC41NjctMi43MTktMTAuMjM4LTIuMjY2LTE0LjUyMS0yLjI2NiAgIGMtMTcuMTMyLDAtMTcuMDU2LDEzLjIyNy0xNy4wNTYsMTYuNTc4djE5OC45NGMwLDIuODMzLTAuMDc1LDE2LjU3OSwxNy4wNTYsMTYuNTc5YzQuMjgzLDAsOS45NTUsMC40NTEsMTQuNTIxLTIuMjY3ICAgbDE1NC40ODMtOTcuMzMzYzEyLjY4LTcuNTQ1LDEwLjQ4OS0xNi40NDksMTAuNDg5LTE2LjQ0OVMyMTYuNDcxLDEwNy4xNzIsMjAzLjc5MSw5OS42Mjh6IiBmaWxsPSIjYzJjNmNmIi8+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==);
}
.player .control-panel .controls .next {
    background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMS4xLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDI1MC40ODggMjUwLjQ4OCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjUwLjQ4OCAyNTAuNDg4OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjEyOHB4IiBoZWlnaHQ9IjEyOHB4Ij4KPGcgaWQ9Ik5leHRfdHJhY2tfMiI+Cgk8cGF0aCBzdHlsZT0iZmlsbC1ydWxlOmV2ZW5vZGQ7Y2xpcC1ydWxlOmV2ZW5vZGQ7IiBkPSJNMjQyLjM4MSwxMTAuNjkzTDE0MC40MTUsMjQuNTkxYy0zLjQ4LTIuNDA2LTcuODA1LTIuMDA1LTExLjA3MS0yLjAwNSAgIGMtMTMuMDYxLDAtMTMuMDAzLDExLjctMTMuMDAzLDE0LjY2NnY2NS4yNDlsLTkyLjI2NS03Ny45MWMtMy40ODItMi40MDYtNy44MDctMi4wMDUtMTEuMDcyLTIuMDA1ICAgQy0wLjA1NywyMi41ODcsMCwzNC4yODcsMCwzNy4yNTJ2MTc1Ljk4M2MwLDIuNTA3LTAuMDU3LDE0LjY2NiwxMy4wMDQsMTQuNjY2YzMuMjY1LDAsNy41OSwwLjQwMSwxMS4wNzItMi4wMDVsOTIuMjY1LTc3LjkxICAgdjY1LjI0OWMwLDIuNTA3LTAuMDU4LDE0LjY2NiwxMy4wMDMsMTQuNjY2YzMuMjY2LDAsNy41OTEsMC40MDEsMTEuMDcxLTIuMDA1bDEwMS45NjYtODYuMTAxICAgYzkuNjY4LTYuNjc1LDcuOTk3LTE0LjU1MSw3Ljk5Ny0xNC41NTFTMjUyLjA0OSwxMTcuMzY3LDI0Mi4zODEsMTEwLjY5M3oiIGZpbGw9IiNjMmM2Y2YiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K);
}
.player .control-panel.active .controls .play {
    background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMS4xLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDIzMi42NzkgMjMyLjY3OSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjMyLjY3OSAyMzIuNjc5OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjEyOHB4IiBoZWlnaHQ9IjEyOHB4Ij4KPGcgaWQ9IlBhdXNlIj4KCTxwYXRoIHN0eWxlPSJmaWxsLXJ1bGU6ZXZlbm9kZDtjbGlwLXJ1bGU6ZXZlbm9kZDsiIGQ9Ik04MC41NDMsMEgzNS43OTdjLTkuODg1LDAtMTcuODk4LDguMDE0LTE3Ljg5OCwxNy44OTh2MTk2Ljg4MyAgIGMwLDkuODg1LDguMDEzLDE3Ljg5OCwxNy44OTgsMTcuODk4aDQ0Ljc0NmM5Ljg4NSwwLDE3Ljg5OC04LjAxMywxNy44OTgtMTcuODk4VjE3Ljg5OEM5OC40NCw4LjAxNCw5MC40MjcsMCw4MC41NDMsMHogTTE5Ni44ODIsMCAgIGgtNDQuNzQ2Yy05Ljg4NiwwLTE3Ljg5OSw4LjAxNC0xNy44OTksMTcuODk4djE5Ni44ODNjMCw5Ljg4NSw4LjAxMywxNy44OTgsMTcuODk5LDE3Ljg5OGg0NC43NDYgICBjOS44ODUsMCwxNy44OTgtOC4wMTMsMTcuODk4LTE3Ljg5OFYxNy44OThDMjE0Ljc4MSw4LjAxNCwyMDYuNzY3LDAsMTk2Ljg4MiwweiIgZmlsbD0iI2MyYzZjZiIvPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=);
}


</style>
