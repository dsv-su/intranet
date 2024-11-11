<div>
    @include('livewire.pp.partials.proposal_files')
    <div x-data="fileUpload()">
        @include('livewire.pp.partials.fileupload_progress')
        <div class="relative cursor-pointer p-6 flex justify-center bg-white border border-dashed border-gray-300 rounded-xl dark:bg-neutral-800 dark:border-neutral-600"
             x-on:drop="isDroppingFile = false"
             x-on:drop.prevent="handleFileDrop($event)"
             x-on:dragover.prevent="isDroppingFile = true"
             x-on:dragleave.prevent="isDroppingFile = false">

            <div class="absolute top-0 bottom-0 left-0 right-0 z-30 flex items-center justify-center bg-blue-500 opacity-90"
                 x-show="isDropping">

                <span class="text-3xl text-white">Release file to upload!</span>

            </div>
            <label class="py-2 flex flex-col items-center justify-center w-full bg-white dark:bg-neutral-800 border border-susecondary shadow cursor-pointer h-1/2 rounded-2xl hover:bg-slate-50 dark:hover:bg-neutral-700">
                <span class="inline-flex justify-center items-center size-16 bg-gray-100 text-gray-800 rounded-full dark:bg-neutral-700 dark:text-neutral-200">
                    <svg class="shrink-0 size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" x2="12" y1="3" y2="15"></line>
                    </svg>
                </span>
                <div class="mt-4 flex flex-wrap justify-center text-sm leading-6 text-gray-600 dark:text-neutral-300">
                    <span class="pe-1 font-medium text-gray-800 dark:text-neutral-200">
                        Drop your file here or
                    </span>
                    <span class="bg-white dark:bg-neutral-800 font-semibold text-blue-600 dark:text-blue-500 hover:text-blue-700 dark:hover:text-blue-600 rounded-lg decoration-2 hover:underline focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-600 focus-within:ring-offset-2">
                        browse
                    </span>
                </div>
                <p class="mt-1 text-xs text-gray-400 dark:text-neutral-400">
                    Allowed file types: txt pdf doc docx ppt pptx odt pages png jpg xls xlsx zip rar tex ps djvu rtf.
                </p>
                <input type="file" id="file-upload" multiple @change="handleFileSelect" class="hidden" />
            </label>


        </div>
        <script>
            function fileUpload() {
                return {
                    isDropping: false,
                    isUploading: false,
                    progress: 0,
                    handleFileSelect(event) {
                        if (event.target.files.length) {
                            this.uploadFiles(event.target.files)
                        }
                    },
                    handleFileDrop(event) {
                        if (event.dataTransfer.files.length > 0) {
                            this.uploadFiles(event.dataTransfer.files)
                        }
                    },
                    uploadFiles(files) {
                        const $this = this;
                        this.isUploading = true
                    @this.uploadMultiple('files', files,
                        function (success) {
                            $this.isUploading = false
                            $this.progress = 0
                            $this.files = []
                        },
                        function(error) {
                            console.log('error', error)
                        },
                        function (event) {
                            $this.progress = event.detail.progress
                        }
                    )
                    @this.checkToggle();
                    },
                    removeUpload(filename) {
                    @this.removeUpload('files', filename);
                    },
                }
            }
        </script>
    </div>

</div>





