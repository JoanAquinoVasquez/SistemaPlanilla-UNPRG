import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react-swc'

// https://vitejs.dev/config/
export default defineConfig({
  base: '/client/',
  plugins: [react()],
  build: {
    rollupOptions: {
      output: {
        manualChunks(id) {
          // Si el archivo pertenece a node_modules, divídelo en un chunk separado
          if (id.includes('node_modules')) {
            return 'vendor';
          }
        },
      },
    },
  },
})
