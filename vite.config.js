import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";
import path from 'path'; // Adaugă această linie

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css', 
        'resources/js/app.js'
      ],
      refresh: true,
    }),
    tailwindcss(),
  ],
  resolve: {
    alias: {
      // Folosește path.resolve după ce ai importat modulul
      '@fortawesome': path.resolve(__dirname, 'node_modules/@fortawesome'),
    }
  },
});