<template>
    <button v-if="!this.user" @click="spotifyAuthentication">
        <span>Connect spotify</span>
    </button>
    <div v-else>
        <div class="spotify-status">
            <h1>Spotify connected!</h1>
        </div>
        <div class="spotify-user">
            Username: {{this.user.display_name}}
        </div>
        <button @click="revokeSpotifyAccess">
            <span>Revoke access</span>
        </button>
    </div>
</template>

<script>
export default {

    data() {
        return {
            user: false
        }
    },

    mounted() {
        this.populateUserObject();
    },

    methods: {

        spotifyAuthentication() {
            window.location.href = "api/spotify/authenticate";
        },

        revokeSpotifyAccess()
        {
            let self = this;
            axios.post('api/spotify/revoke')
                .then(function (response){
                   self.user = false;
                   $cookies.remove('spotify:user');
                });
        },

        populateUserObject() {
            if ($cookies.get('spotify:user')) {
                this.user = $cookies.get('spotify:user');
            }
        },
    }
}
</script>

<style scoped>

button {
    position: relative;
    outline: none;
    text-decoration: none;
    border-radius: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    text-transform: uppercase;
    height: 60px;
    width: 210px;
    opacity: 1;
    background-color: #ffffff;
    border: 1px solid rgba(22, 76, 167, 0.6);
    margin: 0 auto;
}
button span {
    color: #164ca7;
    font-size: 12px;
    font-weight: 500;
    letter-spacing: 0.7px;
}
button:hover {
    animation: rotate 0.7s ease-in-out both;
}
button:hover span {
    animation: storm 0.7s ease-in-out both;
    animation-delay: 0.06s;
}

.spotify-status {
    text-align: center;
}

.spotify-user {
    text-align: center;
    margin: 20px;
}

@keyframes rotate {
    0% {
        transform: rotate(0deg) translate3d(0, 0, 0);
    }
    25% {
        transform: rotate(3deg) translate3d(0, 0, 0);
    }
    50% {
        transform: rotate(-3deg) translate3d(0, 0, 0);
    }
    75% {
        transform: rotate(1deg) translate3d(0, 0, 0);
    }
    100% {
        transform: rotate(0deg) translate3d(0, 0, 0);
    }
}
@keyframes storm {
    0% {
        transform: translate3d(0, 0, 0) translateZ(0);
    }
    25% {
        transform: translate3d(4px, 0, 0) translateZ(0);
    }
    50% {
        transform: translate3d(-3px, 0, 0) translateZ(0);
    }
    75% {
        transform: translate3d(2px, 0, 0) translateZ(0);
    }
    100% {
        transform: translate3d(0, 0, 0) translateZ(0);
    }
}

</style>
