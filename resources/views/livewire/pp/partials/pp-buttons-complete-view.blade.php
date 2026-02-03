@if($proposal->allowComplete())
    <a type="button"
       href="{{ route('pp-complete', $proposal->id) }}"
       class="mr-6 inline-flex items-center px-1.5 py-1.5 rounded-md font-semibold text-[0.5rem] uppercase tracking-widest
          border border-yellow-500 text-yellow-700 bg-yellow-50
          hover:bg-yellow-500 hover:text-black
          active:bg-yellow-600
          focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-offset-2 focus:ring-offset-white
          disabled:opacity-25 transition ease-in-out duration-150
          dark:border-yellow-400 dark:text-yellow-300 dark:bg-yellow-950/40
          dark:hover:bg-yellow-400 dark:hover:text-black
          dark:active:bg-yellow-500
          dark:focus:ring-yellow-500 dark:focus:ring-offset-2 dark:focus:ring-offset-slate-900">
        Complete
    </a>

@endif
{{--}}
<a type="button"
   href="{{route('pp-view', $proposal->id)}}"
   class="inline-flex items-center px-1.5 py-1.5 bg-white border border-green-600 text-green-600 rounded-md font-semibold text-[0.5rem]
                                            uppercase tracking-widest hover:bg-green-600 hover:text-white active:bg-green-700 focus:outline-none focus:border-green-800 focus:ring ring-green-300
                                            disabled:opacity-25 transition ease-in-out duration-150">
    View
</a>
{{--}}
