import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import commonjs from 'vite-plugin-commonjs';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/digital-persona-bundle.js',
                'resources/js/persona.js',
                'resources/js/customFingerprint.js',
                'resources/js/registerFingerprint.js'
            ],
            refresh: true,
        }),
        commonjs({
            // include: ['@digitalpersona/core'], // Add libraries using require()
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
     build: {
        commonjsOptions: {
            include: [/node_modules/],
        },
    },
});


