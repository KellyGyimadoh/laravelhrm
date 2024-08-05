import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    // server: {
    //     host: '0.0.0.0', // Allows access from any network
    //     port: 5173, // Default port for Vite
    //     hmr: {
    //         host: '6c26-196-175-2-131.ngrok-free.app', // Your Ngrok URL without protocol
    //     },
    // },
    // base: '/', // Ensures assets are referenced from the root

});
