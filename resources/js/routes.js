import NotFound from "./components/NotFoundComponent";
import Sports from "./components/SportComponent";
import Settings from "./components/SettingsComponents/MainSettingsComponent";
import Spotify from "./components/SpotifyComponent";

export default {
    mode: 'history',

    linkActiveClass: 'selected-link',

    routes: [
        {
          path: '*',
            component: NotFound
        },

        {
            path: '/',
            component: Spotify
        },

        // {
        //     path: '/spotify',
        //     component: Spotify
        // },

        {
            path: '/sports',
            component: Sports
        },

        {
            path: '/settings',
            component: Settings
        }
    ]
}
