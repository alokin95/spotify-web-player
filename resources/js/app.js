require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';

Vue.use(VueRouter);

Vue.component(
    'music-player',
    require('./components/MusicPlayerComponent.vue').default
    );

const app = new Vue({
    el: '#app',

    router: new VueRouter(routes)
});
