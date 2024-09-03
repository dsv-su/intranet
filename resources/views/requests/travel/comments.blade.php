<article class="md:w-1/4 p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">

    @include('requests.travel.progress')

    @if(!$tr->manager_comment_id == null or !$tr->fo_comment_id == null or !$tr->head_comment_id == null)
        <h2 class="mb-2 mt-4 text-xl font-bold tracking-tight text-gray-900 dark:text-white"><a href="#">{{__("Comments")}}</a></h2>
        <hr class="m-2">
        @if($tr->manager_comment_id)
            <div class="flex justify-between items-center mb-5 text-gray-500">
                <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">Project leader</span>
                  <span class="bg-primary-100 text-primary-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-primary-200 dark:text-primary-800">
                      Comments from {{\App\Models\User::find($tr->managercomment->user_id)->name}}
                  </span>
                <span class="text-sm">{{\Carbon\Carbon::parse($tr->managercomment->updated_at)->format('Y-m-d')}}</span>
            </div>

            <p class="mb-5 font-light text-gray-500 dark:text-gray-400">
                {{ $tr->managercomment->comment }}
            </p>
        <hr>
        @endif
        @if($tr->head_comment_id)
            <div class="flex justify-between items-center mb-5 text-gray-500">
                <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">Unit Head</span>
                  <span class="bg-primary-100 text-primary-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-primary-200 dark:text-primary-800">
                      Comments from {{\App\Models\User::find($tr->headcomment->user_id)->name}}
                  </span>
                <span class="text-sm">{{\Carbon\Carbon::parse($tr->headcomment->updated_at)->format('Y-m-d')}}</span>
            </div>

            <p class="mb-5 font-light text-gray-500 dark:text-gray-400">
                {{ $tr->headcomment->comment }}
            </p>
            <hr class="m-2">
        @endif
        @if($tr->fo_comment_id)
            <div class="flex justify-between items-center mb-5 text-gray-500">
                <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">Financial officer</span>
                <span class="bg-primary-100 text-primary-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-primary-200 dark:text-primary-800">
                      Comments from {{\App\Models\User::find($tr->focomment->user_id)->name}}
                  </span>
                <span class="text-sm">{{\Carbon\Carbon::parse($tr->focomment->updated_at)->format('Y-m-d')}}</span>
            </div>

            <p class="mb-5 font-light text-gray-500 dark:text-gray-400">
                {{ $tr->focomment->comment }}
            </p>
            <hr class="m-2">
        @endif
    @endif
    <!-- Download if approved -->
    @if($tr->state == 'fo_approved')
    <div class="grid grid-cols-1 mt-2">
        <a href="{{route('travel-request-pdf', $tr->id)}}" class="inline-flex items-center justify-center gap-x-1.5 text-blue-800 font-medium py-2 px-4 border border-susecondary rounded-lg w-full text-center dark:text-black">
            {{__("Download")}}
        </a>
    </div>
    @endif
        <!-- end download -->
</article>
