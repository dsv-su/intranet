@if($proposal->allowComplete())
    <a type="button"
       href="{{route('pp-complete', $proposal->id)}}"
       class="mr-6 inline-flex items-center px-1.5 py-1.5 bg-white border border-green-600 text-green-600 rounded-md font-semibold text-[0.5rem]
                                            uppercase tracking-widest hover:bg-green-600 hover:text-white active:bg-green-700 focus:outline-none focus:border-green-800 focus:ring ring-green-300
                                            disabled:opacity-25 transition ease-in-out duration-150">
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
