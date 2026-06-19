import { createApp, h } from 'vue'
import { createInertiaApp, router } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'
import './bootstrap'
import axios from 'axios'

// Set CSRF token on every axios request
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

createInertiaApp({
    title: (title) => title ? `${title} — TeachMe App` : 'TeachMe App',

    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),

    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el)
    },

    progress: {
        color: '#4F46E5',
    },
})