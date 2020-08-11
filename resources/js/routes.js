import NotFound from "./components/NotFoundComponent";
import Home from "./components/HomeComponent";
import Sports from "./components/SportComponent";
import Settings from "./components/SettingsComponents/MainSettingsComponent";

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
            component: Home
        },

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
