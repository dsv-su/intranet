@extends('layouts.app')
@include('dsvheader')
@include('navbar.navbar')
<!-- News -->
<div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
    <div class="max-w-2xl">
        <div class="flex justify-between items-center mb-6">
            <div class="flex w-full sm:items-center gap-x-5 sm:gap-x-3">
                <div class="grow">
                    <div class="flex justify-between items-center gap-x-2">
                        <div>
                            <div class="inline-block">
                                <div class="sm:mb-1 block text-start">
                                      <span class="text-xs text-gray-800 dark:text-gray-200">
                                        Reported by: {!! $page->author->name ?? 'DMC' !!}
                                      </span>
                                </div>
                            </div>
                            <ul class="text-xs text-gray-500">
                                <li class="inline-block relative pe-6 last:pe-0 last-of-type:before:hidden before:absolute before:top-1/2 before:end-2
                                            before:-translate-y-1/2 before:w-1 before:h-1 before:bg-gray-300 before:rounded-full dark:text-gray-400 dark:before:bg-gray-600">
                                    {!! $page->date !!}
                                </li>
                                <li class="inline-block relative pe-6 last:pe-0 last-of-type:before:hidden before:absolute before:top-1/2 before:end-2 before:-translate-y-1/2
                                            before:w-1 before:h-1 before:bg-gray-300 before:rounded-full dark:text-gray-400 dark:before:bg-gray-600">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{$page->collection}}</span>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Content -->
        @nocache('rooms.partials.room')
        <!-- End Content -->
    </div>
</div>
@include('layouts.darktoggler')
