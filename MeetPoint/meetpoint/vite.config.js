// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
  css: {
    preprocessorOptions: {
      scss: {
        includePaths: [path.resolve(__dirname, 'node_modules')],
      },
    },
  },
  plugins: [
    laravel({
      input: ['resources/js/app.js'], // en app.js importas '../sass/app.scss'
      refresh: true,
    }),
  ],
});
