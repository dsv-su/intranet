<h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">
    @php
        $labels = [
            'complete' => isset($proposal) ? __("Complete: ") . $proposal['name'] : __("Complete"),
            'view' => isset($proposal) ? __("View: ") . $proposal['name'] : __("View"),
            'edit' => isset($proposal) ? __("Edit: ") . $proposal['name'] : __("Edit"),
            'review' => isset($proposal) ? __("Review: ") . $proposal['name'] : __("Review"),
        ];
    @endphp
    {{ $labels[$type] ?? __("New Project Proposal") }}
</h2>
