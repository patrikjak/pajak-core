import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import fs from 'fs';

// `/pajak-ui/` resolves to the bind-mounted ui repo in the dev-stack, else vendor/.
const pajakUiPath = fs.existsSync('/pajak-ui')
    ? '/pajak-ui'
    : path.resolve(import.meta.dirname, 'vendor/pajak/ui');

const pajakUiImporter = {
    findFileUrl(url) {
        if (!url.startsWith('/pajak-ui/')) {
            return null;
        }

        const resolved = path.join(pajakUiPath, url.slice('/pajak-ui'.length));
        return new URL(`file://${resolved}`);
    },
};

export default defineConfig({
    css: {
        preprocessorOptions: {
            scss: {
                importers: [pajakUiImporter],
            },
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/assets/js/core.ts',
            ],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                entryFileNames: '[name].js',
                chunkFileNames: '[name].js',
                assetFileNames: '[name].[ext]',
            },
        },
        manifest: false,
        emptyOutDir: true,
        outDir: 'public/assets',
    },
    server: {
        host: '0.0.0.0',
        origin: 'https://vite.core.pajak.local',
        cors: {
            origin: 'https://core.pajak.local',
        },
        hmr: {
            host: 'vite.core.pajak.local',
            protocol: 'wss',
        },
    },
});
