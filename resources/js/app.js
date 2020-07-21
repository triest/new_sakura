/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('anket-list', require('./components/anket/anket-list.vue').default);
Vue.component('chat-app', require('./components/chat/ChatApp.vue').default);
Vue.component('event-in-my-city-side', require('./components/events/EventInMyCitySide2').default);
Vue.component('event-requwest', require('./components/events/event-requwest').default);
Vue.component('requwest-check', require('./components/events/requwest-check').default);
Vue.component('anket-component', require('./components/anket/anket-component').default);
Vue.component('anket-component2', require('./components/anket/anket-component2').default);
Vue.component('like-carusel', require('./components/like-carusel/like-carusel').default);
Vue.component('presents-admin-list', require('./components/admin/presents/presents-list').default);
Vue.component('my-presents-modal', require('./components/anket/myPresentsModal').default);
Vue.component('sidebar', require('./components/layouts/sidebar').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



window.addEventListener('load', function () {
    //your script
    const app = new Vue({
        el: '#app',
    });
})