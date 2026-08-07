import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/sass/product.scss',
                'resources/sass/admin.scss',
                'resources/js/app.js',
                'resources/js/product.js',
                'resources/js/product-page.js',
                'resources/js/frontend.js',
                'resources/js/admin-dashboard.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
