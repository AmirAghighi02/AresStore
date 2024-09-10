import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        outDir: '../../public/build-responsehandler',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-responsehandler',
            input: [
                __dirname + '/resources/assets/sass/App.scss',
                __dirname + '/resources/assets/js/App.js'
            ],
            refresh: true,
        }),
    ],
});

//export const paths = [
//    'Modules/ResponseHandler/resources/assets/sass/App.scss',
//    'Modules/ResponseHandler/resources/assets/js/App.js',
//];
