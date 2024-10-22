@if($proposal->dashboard->state == 'submitted')
    @php
        $state = 'SUBMITTED';
        $bgcolor = 'bg-yellow-100';
        $textcolor = 'text-yellow-800';
    @endphp
@elseif($proposal->dashboard->state == 'head_approved')
    @php
        $state = 'REVIEW VH';
        $bgcolor = 'bg-purple-100';
        $textcolor = 'text-purple-800';
    @endphp
@elseif($proposal->dashboard->state == 'vice_approved')
    @php
        $state = 'REVIEW FO';
        $bgcolor = 'bg-blue-100';
        $textcolor = 'text-blue-800';
    @endphp
@elseif($proposal->dashboard->state == 'fo_approved')
    @php
        $state = 'APPROVED';
        $bgcolor = 'bg-yellow-100';
        $textcolor = 'text-yellow-800';
    @endphp
@else
    @php
        $state = 'ERROR';
        $bgcolor = 'bg-yellow-100';
        $textcolor = 'text-yellow-800';
    @endphp
@endif

<span class="{{$bgcolor}} {{$textcolor}} text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
    {{ $state }}
</span>
