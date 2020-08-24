<template>
    <div id="spotify-container">
        <div id="spotify-search">
            <div class="search__container">
                <input class="search__input" type="text" placeholder="Search">
            </div>
        </div>
        <div id="spotify-content-container">
            <h1 id="artists-heading">Favorite artists</h1>
            <div id="favorite-artists">
                <div id="artist" v-for="artist in this.artists">
                    <div id="artist-image" class="image-container">
                        <img v-bind:src="artist.image.url" alt="Artist image">

                        <div class="play-button" @click="playSpotifyUri(artist.artistUri)">

                            <svg version="1.1" id="play" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="100px" width="100px"
                                 viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
  <path class="stroke-solid" fill="none" stroke="#ddbe72"  d="M49.9,2.5C23.6,2.8,2.1,24.4,2.5,50.4C2.9,76.5,24.7,98,50.3,97.5c26.4-0.6,47.4-21.8,47.2-47.7
    C97.3,23.7,75.7,2.3,49.9,2.5"/>
                                <path class="icon" fill="#ddbe72" d="M38,69c-1,0.5-1.8,0-1.8-1.1V32.1c0-1.1,0.8-1.6,1.8-1.1l34,18c1,0.5,1,1.4,0,1.9L38,69z"/>
</svg>


                        </div>

                    </div>
                    <div id="artist-name">
                        {{artist.name}}
                    </div>
                </div>
            </div>

            <h1 id="track-heading">Favorite tracks</h1>
            <div id="favorite-tracks">
                <div id="track" v-for="track in this.tracks">
                    <div id="track-image" class="image-container">
                        <img v-bind:src="track.image.url" alt="Track image">
                        <div class="play-button" @click="playSpotifyUri(track.trackUri)">

                            <svg version="1.1" id="play" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="100px" width="100px"
                                 viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
  <path class="stroke-solid" fill="none" stroke="#ddbe72"  d="M49.9,2.5C23.6,2.8,2.1,24.4,2.5,50.4C2.9,76.5,24.7,98,50.3,97.5c26.4-0.6,47.4-21.8,47.2-47.7
    C97.3,23.7,75.7,2.3,49.9,2.5"/>
                                <path class="icon" fill="#ddbe72" d="M38,69c-1,0.5-1.8,0-1.8-1.1V32.1c0-1.1,0.8-1.6,1.8-1.1l34,18c1,0.5,1,1.4,0,1.9L38,69z"/>
</svg>

                        </div>
                    </div>
                    <div id="track-name">
                        {{track.name}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            artists: [],
            tracks: []
        }
    },

    mounted() {
        this.getMostListenedArtistsAndTracks();
    },

    methods: {

        playSpotifyUri(uri) {
            let deviceId = window.SpotifyPlayerId;
            axios.post('api/spotify/play', {
                deviceId,
                uri
            });
        },

        getMostListenedArtistsAndTracks() {
          let self = this;
          axios.get('api/spotify/popular')
            .then( response => {
                self.artists = response.data.artists;
                self.tracks = response.data.tracks;
            })
        }

    }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css?family=Raleway:400,700,900');

#spotify-container {
    width: 100%;
}

#spotify-content-container {
    margin-top: 100px;
}

.search__container {
    width: 20%;
    margin: 0 auto;
}

#favorite-artists {
    display: flex;
    justify-content: space-around;
}

#favorite-tracks {
    display: flex;
    justify-content: space-around;
}

#track {
    text-align:center;
    color: white;
}

#artist {
    text-align: center;
    color: white;
}

#artists-heading {
    color: white;
    font-weight: bolder;
    margin: 50px;
}

#track-heading {
    color: white;
    font-weight: bolder;
    margin: 50px;
}

#artist-image {
    width: 160px;
    height: 160px;
    overflow: hidden;
    border-radius: 100%;
}

#artist-image img {
    min-height: 160px;
}

#track-image {
    width: 160px;
    height: 160px;
    overflow: hidden;
}

#track-image img {
    width: 160px;
    height: 160px;
}

#track-name {
    margin: 0 auto;
    margin-top: 10px;
    max-width: 100px;
}

#artist-name {
    margin: 10px;
    font-weight: bolder;
}

.search__input {
    width: 100%;
    padding: 12px 24px;
    transition: transform 250ms ease-in-out;
    font-size: 14px;
    line-height: 18px;

    color: #575756;
    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'%3E%3Cpath d='M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z'/%3E%3Cpath d='M0 0h24v24H0z' fill='none'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-size: 18px 18px;
    background-position: 95% center;
    border-radius: 50px;
    border: 1px solid #575756;
}

.search__input::placeholder {
    color: rgba(87, 87, 86, 0.8);
    text-transform: uppercase;
    letter-spacing: 1.5px;
}

.image-container {
    position: relative;
    width: 200px;
    height: 300px;
}

.image-container .play-button {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: none;
    color: #FFFF;
}

.image-container:hover .play-button {
    display: block;
    background: rgba(0, 0, 0, .6);
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}
.stroke-solid {
    stroke-dashoffset: 0;
    stroke-dashArray: 300;
    stroke-width: 4px;
    transition: stroke-dashoffset 1s ease,  opacity 1s ease;
}

.icon {
    transform: scale(0.8);
    transform-origin: 50% 50%;
    transition: transform 200ms ease-out;
}

#play:hover .stroke-solid {
    opacity: 1;
    stroke-dashoffset: 300;
}
#play:hover .icon {
    transform: scale(0.9);
}

#play {
    cursor: pointer;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translateY(-50%) translateX(-50%);
}


</style>
