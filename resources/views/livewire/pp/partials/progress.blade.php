@if($proposal->dashboard->state == 'submitted')
    @php
        $progress = 25;
        $color = 'bg-yellow-400';
    @endphp
@elseif($proposal->dashboard->state == 'head_approved')
    @php
        $progress = 50;
        $color = 'bg-purple-600';
    @endphp
@elseif($proposal->dashboard->state == 'vice_approved')
    @php
        $progress = 75;
        $color = 'bg-blue-600';
    @endphp
@elseif($proposal->dashboard->state == 'fo_approved')
    @php
        $progress = 100;
        $color = 'bg-green-600';
    @endphp
@else
    @php
        $progress = 0;
    @endphp
@endif
<div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100">
    <div class="flex flex-col justify-center rounded-full overflow-hidden {{$color}} text-[0.5rem] text-white text-center whitespace-nowrap dark:bg-blue-500 transition duration-500" style="width: {{$progress}}%">{{$progress}}%</div>
</div>
