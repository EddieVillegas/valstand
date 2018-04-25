
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//window.Vue = require('vue');
import Vue from 'vue';
import VueClip from 'vue-clip';
import vue2Dropzone from 'vue2-dropzone'
Vue.use(VueClip);
Vue.component('administradores', require('./components/administradores/Administradores.vue'));
Vue.component('noticias', require('./components/noticias/Noticias.vue'));
Vue.component('proyectos', require('./components/proyectos/Proyectos.vue'));
Vue.component('socios', require('./components/socios/Socios.vue'));
Vue.component('usuarios', require('./components/usuarios/Usuarios.vue'));
Vue.component('subastas', require('./components/subastas/Subastas.vue'));
Vue.component('contacto', require('./components/contactos/Contacto.vue'));
Vue.component('modal', require('./components/components/Modal.vue'));
Vue.component('tabla', require('./components/components/Table.vue'));
Vue.component('navbar', require('./components/components/Navbar.vue'));
Vue.component('paginator', require('./components/components/Paginator.vue'));
Vue.component('vueDropzone', vue2Dropzone);
const app = new Vue({
    el: '#app'
});
