<div class="flex flex-col flex-1 w-full">
    <main class="relative flex-1 focus:outline-none overflow-y-auto">
        <div class="py-6">
            <div class="px-4 mx-auto max-w-6xl sm:px-6 md:px-6">
                <div class="py-4">
                    <article class="mt-4 mb-4 bg-white p-8 shadow-xl rounded-xl max-w-full prose dark:prose-invert dark:bg-gray-800 dark:text-white antialiased">
                        <h2 class="mb-4 text-2xl tracking-tight font-bold text-gray-900 dark:text-white">
                            {!! $page->title !!}
                        </h2>
                        @if(isset($page->intro))
                            <h4 class="max-w-xl mt-4 text-base tracking-tight text-gray-600 dark:text-white dark:prose-invert">
                                {!! $page->intro !!}
                            </h4>
                        @endif
                        @foreach($page->content as $content)
                            @if($content->type == "text")
                                <div class="md:hidden table-auto text-xs dark:text-white">
                                    {!! $content->text !!}
                                </div>
                                <div class="hidden sm:hidden md:block dark:text-white">
                                    {!! $content->text !!}
                                </div>
                            @elseif($content->type == "fileassets")
                                <ul class="space-y-3 text-xs">
                                    @foreach($content->file as $file)
                                        <li class="flex space-x-3">
                                            <a href="{{$file->url}}" class="inline-flex items-center justify-center p-3 text-sm font-medium text-gray-500 rounded-lg bg-gray-50 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white">
                                                <svg class="w-6 h-6 mr-2 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 19">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 15h.01M4 12H2a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-3M9.5 1v10.93m4-3.93-4 4-4-4"/>
                                                </svg>
                                                <span class="text-gray-800 dark:text-gray-400">{{$file->filename}} ({{$file->size}})</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @elseif($content->type == "images")
                                @foreach($content->image as $image)
                                    <div class="border border-blue-600">
                                        <img class="rounded-t-lg max-w-full" src="{{$image->url}}" alt="" />
                                    </div>
                                @endforeach
                            @elseif($content->type == "faq_group")
                                @include('partials.faq')
                            @endif
                        @endforeach
                        <div class="text-gray-600 text-sm bg-white p-3 rounded-md leading-none dark:bg-gray-800 dark:text-white">
                            <hr>
                            <p><i>{{__("Responsible for the page:")}} {!! $page->author->name ?? 'NN' !!}</i></p>
                            <p><i>{{__("Last edited:")}} {!! $page->last_modified !!}</i></p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </main>
</div>
