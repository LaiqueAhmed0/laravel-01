import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel([
            'resources/src/app.ts',
        ]),
    ],
    resolve: {
        alias: {
            '@': '/resources/src'
        }
    }
});