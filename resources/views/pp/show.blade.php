@extends('layouts.app')
<div class="max-w-[50rem] flex flex-col mx-auto size-full">
    <!-- ========== HEADER ========== -->
    <header class="mb-auto flex justify-center z-50 w-full py-4">
        <nav class="px-4 sm:px-6 lg:px-8">
            <a class="flex-none text-xl font-semibold sm:text-3xl dark:text-white" href="#" aria-label="Brand">PP</a>
        </nav>
    </header>
    <!-- ========== END HEADER ========== -->

    <!-- ========== MAIN CONTENT ========== -->
    <main id="content">
        <div class="text-center py-10 px-4 sm:px-6 lg:px-8">
            <h1 class="block text-lg font-bold text-gray-800 sm:text-9xl dark:text-white">{{ $pp['title'] }}</h1>

            <p class="text-gray-600 dark:text-neutral-400">{{ $pp['main resercher'] }}</p>
            <p class="text-gray-600 dark:text-neutral-400">{{ $pp['co-applicants'] }}</p>
            <div class="mt-5 flex flex-col justify-center items-center gap-2 sm:flex-row sm:gap-3">
                <a class="w-full sm:w-auto py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" href="/test">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                    Back
                </a>
            </div>
        </div>
    </main>
    <!-- ========== END MAIN CONTENT ========== -->

    <!-- ========== FOOTER ========== -->
    <footer class="mt-auto text-center py-5">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-sm text-gray-500 dark:text-neutral-500">DSV PP</p>
        </div>
    </footer>
    <!-- ========== END FOOTER ========== -->
</div>
