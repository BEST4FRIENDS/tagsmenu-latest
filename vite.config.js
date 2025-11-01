import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    // WICHTIG: Konfiguration für Docker/Sail
    server: {
        host: '0.0.0.0',
        hmr: {
            host: 'localhost',
        },
        // Optional, aber empfohlen bei Latenzproblemen (z.B. WSL2)
        // watch: {
        //      usePolling: true,
        // }
    },
});