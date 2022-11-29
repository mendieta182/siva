import './bootstrap';
import '../css/app.css';
/* Custom */
import ClickOutside from './click-outside'


import { createApp, h } from 'vue';
/* Multi-language */
import { i18nVue } from 'laravel-vue-i18n';

import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
const options = {
    confirmButtonColor: '#41b882',
    cancelButtonColor: '#ff7674',
  };

/* Vue Gates */
import VueGates from 'vue-gates';
import Permissions from './Plugins/Permissions';


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(VueGates)
            .use(Permissions)
            .use(ZiggyVue, Ziggy)
            .use(i18nVue, {
                resolve: async lang => {
                    const langs = import.meta.glob('../../lang/*.json');
                    return await langs[`../../lang/${lang}.json`]();
                }
            })
            .use(VueSweetalert2,options)
            .directive('click-outside', ClickOutside)          
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
