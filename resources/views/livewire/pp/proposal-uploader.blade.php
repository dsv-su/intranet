<div class="cursor-pointer p-12 flex justify-center bg-white border border-dashed border-gray-300 rounded-xl dark:bg-neutral-800 dark:border-neutral-600" x-data="fileUpload()">
    <div class="text-center">
          <span class="inline-flex justify-center items-center size-16 bg-gray-100 text-gray-800 rounded-full dark:bg-neutral-700 dark:text-neutral-200">
            <svg class="shrink-0 size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
              <polyline points="17 8 12 3 7 8"></polyline>
              <line x1="12" x2="12" y1="3" y2="15"></line>
            </svg>
          </span>

        <div class="mt-4 flex flex-wrap justify-center text-sm leading-6 text-gray-600">
            <span class="pe-1 font-medium text-gray-800 dark:text-neutral-200">
              Drop your file here or
            </span>
            <span class="bg-white font-semibold text-blue-600 hover:text-blue-700 rounded-lg decoration-2 hover:underline focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-600 focus-within:ring-offset-2 dark:bg-neutral-800 dark:text-blue-500 dark:hover:text-blue-600">browse</span>
        </div>

        <p class="mt-1 text-xs text-gray-400 dark:text-neutral-400">
            File
        </p>
        <input type="file" id="file-upload" multiple @change="handleFileSelect" class="hidden" />
    </div>
</div>



    <script>
        function fileUpload() {
            return {
                isDropping: false,
                isUploading: false,
                progress: 0,
                handleFileSelect(event) {
                    if (event.target.files.length) {
                        console.log(event.target.files)
                    }
                },
            }
        }
    </script>
</div>
