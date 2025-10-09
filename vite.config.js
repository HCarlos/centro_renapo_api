import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

// 'resources/js/js/arjiapp.js',
// 'resources/css/general.css'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
                reactivityTransform: true,
            },
        }),
        // inject({
        //     $: 'jquery',
        //     jQuery: 'jquery',
        // }),

    ],
    server: {
        // host: '192.168.56.88',
        host: '192.168.255.2',
        mimetype: 'text/html',
        watch: {
            usePolling: true,
        },
        cors: true, // Habilita CORS para el servidor de desarrollo de Vite
    },
    optimizeDeps: {
        include: [],
    },
    build: {
        chunkSizeWarningLimit: 10000,
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes('node_modules')) {
                        return 'vendor'
                    }
                }
            }
        }
    }
});
