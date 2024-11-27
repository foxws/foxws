import { defineConfig } from "vite";
import { readFileSync } from "fs";
import { fileURLToPath, URL } from "url";
import { VitePWA } from "vite-plugin-pwa";
import laravel, { refreshPaths } from "laravel-vite-plugin";

export default defineConfig(({ mode }) => {
  let https = false;

  if (mode === "development") {
    https = {
      cert: readFileSync("/run/secrets/cert.pem"),
      key: readFileSync("/run/secrets/key.pem"),
    };
  }

  return {
    server: {
      host: "0.0.0.0",
      https,
      port: 5174,
      strictPort: true,
      hmr: {
        host: "foxws.lan",
        clientPort: 5174,
      },
      watch: {
        ignored: ["**/storage/**"],
      },
    },
    resolve: {
      alias: {
        "@": fileURLToPath(new URL("./", import.meta.url)),
        "~": fileURLToPath(new URL("./node_modules", import.meta.url)),
        "!": fileURLToPath(new URL("./vendor", import.meta.url)),
      },
    },
    plugins: [
      laravel({
        input: ["resources/css/app.css", "resources/js/app.js"],
        refresh: [...refreshPaths, "resources/**", "src/**"],
      }),
      VitePWA({
        buildBase: "/build/",
        scope: "/",
        registerType: "autoUpdate",
        injectRegister: "script-defer",
        workbox: {
          cleanupOutdatedCaches: true,
          directoryIndex: null,
          globPatterns: ["**/*.{js,css,html,svg,jpg,png,webp,ico,txt,woff,woff2}"],
          maximumFileSizeToCacheInBytes: 4194304,
          navigateFallback: null,
          navigateFallbackDenylist: [/\/[api,livewire]+\/.*/],
        },
        manifest: {
          name: "Foxws",
          short_name: "Foxws",
          description: "A personal blog of my Laravel adventures.",
          categories: ["laravel", "development", "packages"],
          theme_color: "#334155",
          background_color: "#334155",
          display_override: ["standalone", "minimal-ui"],
          display: "standalone",
          orientation: "natural",
          id: "/",
          scope: "/",
          start_url: "/",
          icons: [
            {
              src: "/storage/images/android-chrome-192x192.png",
              sizes: "192x192",
              type: "image/png",
            },
            {
              src: "/storage/images/android-chrome-512x512.png",
              sizes: "512x512",
              type: "image/png",
              purpose: "any maskable",
            },
          ],
        },
      }),
    ],
    build: {
      chunkSizeWarningLimit: 1024,
      rollupOptions: {
        output: {
          manualChunks: {
            utils: ["axios"],
            ws: ["pusher-js", "laravel-echo"],
            pwa: ["virtual:pwa-register"],
          },
        },
      },
    },
  };
});
