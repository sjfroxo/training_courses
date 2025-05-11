import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: 'localhost', // или 0.0.0.0 если нужно на локалке
        port: 5173,
        strictPort: true,
        cors: true,
        origin: 'http://localhost:5173',
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/init-text-editor.js',
            ],
            refresh: true,
        }),
    ],
});
