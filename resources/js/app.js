require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import Toaster from '@meforma/vue-toaster';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        const socialApp = createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(Toaster)
            .mixin({ methods: { route } });

            socialApp.config.globalProperties.$echo = window.Echo;
            socialApp.mount(el);

        return socialApp;
    },
});

InertiaProgress.init({ color: '#4B5563' });