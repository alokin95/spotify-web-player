require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import VueCookies from 'vue-cookies';
import routes from './routes';

Vue.use(VueCookies);
Vue.use(VueRouter);

Vue.$cookies.config('-1');

Vue.component(
    'music-player',
    require('./components/MusicPlayerComponent.vue').default
    );

window.Vue = require('vue');

window.Event = new Vue();

const app = new Vue({
    el: '#app',

    router: new VueRouter(routes)
});
