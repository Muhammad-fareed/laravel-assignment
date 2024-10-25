import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/css/adminlte.css',
                // other inputs as needed
            ],
            refresh: true,
        }),
    ],
});
