require('./bootstrap');

import Vue from 'vue';

import { InertiaApp } from '@inertiajs/inertia-vue';
import { InertiaForm } from 'laravel-jetstream';
import PortalVue from 'portal-vue';
import EventHub from 'vue-event-hub';
import VueSweetalert2 from 'vue-sweetalert2';
import { InertiaProgress } from '@inertiajs/progress';
import CKEditor from '@ckeditor/ckeditor5-vue2';
import 'sweetalert2/dist/sweetalert2.min.css';
import VuePersianDatetimePicker from 'vue-persian-datetime-picker';
import VueLazyload from 'vue-lazyload';
import fullscreen from 'vue-fullscreen';
import ZoomOnHover from "vue-zoom-on-hover";
import VueMeta from 'vue-meta';
Vue.mixin({ methods: { route } });
Vue.use(ZoomOnHover);
Vue.use(fullscreen);
import VueIziToast from 'vue-izitoast';
import 'izitoast/dist/css/iziToast.css';
import 'izitoast/dist/css/iziToast.min.css';
Vue.use(VueIziToast);
Vue.use(VueSweetalert2);
Vue.use(InertiaApp);
Vue.use(CKEditor);
Vue.use(EventHub);
Vue.use(InertiaForm);
Vue.component('date-picker', VuePersianDatetimePicker);
Vue.use(PortalVue);
Vue.use(VueMeta, {
    refreshOnceOnNavigation: false
});
Vue.use(VueLazyload, {
    preLoad: 1,
    error: '/img/404Image.jpg',
    loading: '/img/loadingImage.gif',
    attempt: 1
});
InertiaProgress.init({
    delay: 250,
    color: '#F71938',
    includeCSS: true,
    showSpinner: false,
})

const app = document.getElementById('app');

new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount(app);


Vue.filter('NumFormat', function(value) {
    if(!value) return '0';
    value = `${value}`;
    var intPart = Number(value).toFixed(0);
    var intPartFormat = intPart.toString().replace(/(\d)(?=(?:\d{3})+$)/g, '$1,');
    var floatPart = "";
    var value2Array = value.split(".");
    if(value2Array.length == 2) {
        floatPart = value2Array[1].toString();
        if(floatPart.length == 1) {
            return intPartFormat + "." + floatPart + '0';
        } else {
            return intPartFormat + "." + floatPart;
        }
    } else {
        return intPartFormat + floatPart;
    }
})
