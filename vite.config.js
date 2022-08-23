import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { quasar, transformAssetUrls } from '@quasar/vite-plugin';

export default defineConfig({
    plugins: [
        vue({ template: transformAssetUrls }),
        quasar({
            sassVariables: 'resources/css/quasar-variables.sass'
        }),
        laravel({
            input: ['resources/css/app.scss', 'resources/js/app.ts'],
            refresh: true,
        }),
    ],
});
