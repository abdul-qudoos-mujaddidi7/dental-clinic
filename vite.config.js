import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    resolve: {
        alias: {
            // Alias for Vue to use the ESM build that includes the compiler
            'vue': 'vue/dist/vue.esm-bundler.js',
        },
    },
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    build: {
        chunkSizeWarningLimit: 10000,
    },
});
// =======