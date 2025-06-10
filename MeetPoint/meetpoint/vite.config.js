// vite.config.js
import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import path from "path";

export default defineConfig({
    css: {
        preprocessorOptions: {
            scss: {
                includePaths: [
                    path.resolve(__dirname, "node_modules"),
                    path.resolve(__dirname, "resources/sass"),
                ],
            },
        },
    },
    plugins: [
        laravel({
            input: ["resources/js/app.js", "resources/sass/app.scss"],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            // @use "~components/index" as *;
            "~": path.resolve(__dirname, "resources/sass"),
            // para usar @use 'abstracts/variables' en vez
            // de rutas relativas largas
            "@": path.resolve(__dirname, "resources/sass"),
        },
        extensions: [".js", ".vue"],
    },
    assetsInclude: ["**/*.ttf"],
});
