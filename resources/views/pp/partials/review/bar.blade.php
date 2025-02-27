<!-- Toggle Button (Always Visible) -->
<button id="toggleButton" class="fixed bottom-1 right-5 py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
    Toggle Review
</button>

<div id="reviewBox" class="fixed bottom-20 left-0 z-50 w-full bg-white dark:bg-gray-900 dark:border-gray-600">
    <form method="POST" action="{{route('pp-decision')}}" >
        @csrf
        <div class="max-w-2xl mx-auto my-4">
            <label for="comment" class="block mb-2 text-sm font-medium text-blue-600 dark:text-white">
                {{ __("Please Review and Comment") }}
            </label>
            @include('pp.partials.review.review_overview')
            <textarea id="comment" rows="4" name="comment"
                      class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-blue-600
                         focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600
                         dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                      placeholder="Please comment the request">
            </textarea>
            <input type="hidden" name="id" value="{{$proposal->id}}">
        </div>

        <div class="grid h-full max-w-2xl grid-cols-4 bg-white mx-auto font-medium space-x-2">
            <a href="{{ url()->previous() }}" type="button"
               class="inline-flex items-center justify-center px-5 py-2 text-blue-700 font-semibold border border-blue-500
                  rounded hover:bg-blue-500 hover:text-white dark:hover:bg-gray-800 dark:border-gray-600 group">
                <span class="text-sm dark:text-gray-400 group-hover:text-white">{{ __("Cancel") }}</span>
            </a>

            <button type="submit" name="decision" value="deny"
                    class="inline-flex items-center justify-center px-5 py-2 text-red-600 font-semibold border border-red-600
                       rounded hover:bg-red-600 hover:text-white dark:hover:bg-gray-800 dark:border-gray-600 group">
                <span class="text-sm dark:text-gray-400 group-hover:text-white">{{ __("Deny") }}</span>
            </button>

            <button type="submit" name="decision" value="return"
                    class="inline-flex items-center justify-center px-5 py-2 font-semibold text-yellow-400 border border-yellow-400
                       rounded hover:bg-yellow-400 hover:text-white dark:hover:bg-gray-800 dark:border-gray-600 group">
                <span class="text-sm dark:text-gray-400 group-hover:text-white">{{ __("Return") }}</span>
            </button>

            <button type="submit" name="decision" value="approve"
                    class="inline-flex items-center justify-center px-5 py-2 text-blue-700 font-semibold border border-blue-500
                       rounded hover:bg-blue-500 hover:text-white dark:hover:bg-gray-800 dark:border-gray-600 group">
                <span class="text-sm dark:text-gray-400 group-hover:text-white">{{ __("Approve") }}</span>
            </button>
        </div>
    </form>
</div>
<script>
    document.getElementById("toggleButton").addEventListener("click", function () {
        var box = document.getElementById("reviewBox");
        var button = document.getElementById("toggleButton");

        if (box.classList.contains("hidden")) {
            box.classList.remove("hidden");
            button.textContent = "Hide Review";
        } else {
            box.classList.add("hidden");
            button.textContent = "Show Review";
        }
    });
</script>



