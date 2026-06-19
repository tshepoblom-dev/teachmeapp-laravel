import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: ['resources/js/app.js', 'resources/css/app.css'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
            resolve: {
                alias: {
                    '@':    path.resolve(__dirname, 'resources/js'),
                },
            },


        }),
    ],
     // ── Production build options ──────────────────────────────────────────────
    build: {
        // Raise the chunk-size warning limit slightly (Inertia apps are large)
        chunkSizeWarningLimit: 1200,
 
        rollupOptions: {
            output: {
                // Vendor split — keeps the main bundle smaller and lets browsers
                // cache heavy libraries (Vue, Pusher, etc.) independently.
                manualChunks(id) {
                    if (id.includes('node_modules')) {
                        if (id.includes('pusher-js'))         return 'pusher'
                        if (id.includes('@inertiajs'))        return 'inertia'
                        if (id.includes('vue'))               return 'vue'
                        return 'vendor'
                    }
                },
            },
        },
    },
})