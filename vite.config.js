export default defineConfig({
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    editor: ['react-quill'],
                    combobox: ['react-select'],
                    upload: ['react-dropzone']
                }
            }
        }
    }
});