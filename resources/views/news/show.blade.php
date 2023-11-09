@extends('layouts.app')
@include('dsvheader')
@include('navbar.navbar')
<!-- News -->
<div class="max-w-3xl px-4 pt-6 lg:pt-10 pb-12 sm:px-6 lg:px-8 mx-auto">
    <div class="max-w-2xl">
        <div class="flex justify-between items-center mb-6">
            <div class="flex w-full sm:items-center gap-x-5 sm:gap-x-3">
                <div class="grow">
                    <div class="flex justify-between items-center gap-x-2">
                        <div>
                            <div class="inline-block">
                                <div class="sm:mb-1 block text-start">
                                      <span class="font-semibold text-gray-800 dark:text-gray-200">
                                        {!! $page->author->name !!}
                                      </span>
                                </div>
                            </div>
                            <ul class="text-xs text-gray-500">
                                <li class="inline-block relative pe-6 last:pe-0 last-of-type:before:hidden before:absolute before:top-1/2 before:end-2 before:-translate-y-1/2 before:w-1 before:h-1 before:bg-gray-300 before:rounded-full dark:text-gray-400 dark:before:bg-gray-600">
                                    {!! $page->date !!}
                                </li>
                                <li class="inline-block relative pe-6 last:pe-0 last-of-type:before:hidden before:absolute before:top-1/2 before:end-2 before:-translate-y-1/2 before:w-1 before:h-1 before:bg-gray-300 before:rounded-full dark:text-gray-400 dark:before:bg-gray-600">
                                    Internal news
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- End Avatar Media -->

        <!-- Content -->
        <div class="space-y-5 md:space-y-8">
            <div class="space-y-3">
                <h2 class="text-2xl font-bold md:text-3xl dark:text-white"> {!! $page->title !!}</h2>

                <p class="text-lg text-gray-800 dark:text-gray-200">{!! $page->content !!}</p>
            </div>
        </div>
        <!-- End Content -->
    </div>
</div>
@include('layouts.darktoggler')