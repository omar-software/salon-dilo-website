import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

// Vite-Konfiguration für Laravel und Vue
export default defineConfig({
    plugins: [
        // Laravel-Vite-Plugin lädt CSS und JavaScript
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),

        // Vue-Plugin aktiviert .vue Komponenten
        vue(),
    ],
});