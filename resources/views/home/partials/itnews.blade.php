@foreach (\Statamic\Statamic::tag('collection:itnews')->limit(3)->fetch() as $entry)
    <div class="mt-4 text-gray-900 text-xs dark:text-gray-400">
        {{ $entry['date'] }}  {{-- $entry['author']->name ?? '' --}}
    </div>
    <a href="{{$entry['url']}}" class="inline text-left items-center gap-x-1.5 text-blue-800 font-medium">
        {{ $entry['title'] }}
        <svg class="inline w-2.5 h-2.5" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path d="M5.27921 2L10.9257 7.64645C11.1209 7.84171 11.1209 8.15829 10.9257 8.35355L5.27921 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
        </svg>
    </a>
@endforeach
