<div wire:poll.visible>
    <!-- TL -->
    <style>
        .statuscontainer {
            display: flex;
            flex-wrap: wrap;
        }

        .init {
            flex: 0 0 auto;
            text-align: start;
            /*width: 168px;*/
            height: 28px;
            border-radius: 5px;
            margin: auto;
            position: relative;
            /*right: 0;*/
            display: inline-block;
            margin-bottom: 40px;
        }

        .recorder {
            flex: 0 0 auto;
            text-align: center;
            width: 100px;
            height: 42px;
            margin: auto;
            position: relative;
            left: 0;
            margin-bottom: 40px;
        }

        .tab {
            position: absolute;
            top: -20px;
            left: -3px;

            border-left: 1px solid blue;
            border-top: 1px solid blue;
            border-top-left-radius: 5px;
            padding: 5px 10px;
            z-index: 1;
            width: 130px;
        }

        .recordertab {
            position: absolute;
            border-top: 1px solid blue;
            border-right: 1px solid blue;
            top: -20px;
            left: -3px;
            padding: 5px 10px;
            z-index: 1;
        }
        .light {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            margin: 5px;
            background: black;
            display: inline-block;
            position: relative;
            z-index: 2;
        }
    </style>

    @foreach(\Statamic\Statamic::tag('collection:roomsstatus') as $page)
        <div class="statuscontainer">
            <a href="#" class="init">
                <div class="tab">
                    <p class="mb-2 text-sm font-semibold text-blue-600">{!! $page->title !!}</p>
                </div>
                @if($page->projector == false && $page->recorder == false && $page->room == false)
                    <div class="light" data-tooltip-target="first" style="background: green"></div>
                    <div class="inline">
                        <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">OK</span>
                    </div>
                @else
                    <div class="light" data-tooltip-target="first" style="@if($page->projector == true ) background: red @elseif(!empty($page->projector_status)) background: yellow @else background: green @endif"></div>
                    <div class="light" data-tooltip-target="second" style="@if($page->recorder == true ) background: red @elseif(!empty($page->recorder_status)) background: yellow @else background: green @endif"></div>
                    <div class="light" data-tooltip-target="third" style="@if($page->room == true ) background: red @elseif(!empty($page->room_status)) background: yellow @else background: green @endif"></div>
                @endif
            </a>
            {{--}}
            <div class="recorder">
                <div class="recordertab">
                    <p class="mb-2 text-sm font-semibold text-blue-600">Recording</p>
                </div>
                <div class="mt-6">
                    <i class="fa-solid fa-xl fa-video-slash"></i>
                </div>
            </div>
            {{--}}
            @can('access cp')
                <div class="z-10">
                    <a href="{{$page->edit_url}}" >
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.1" d="m14.3 4.8 2.9 2.9M7 7H4a1 1 0 0 0-1 1v10c0 .6.4 1 1 1h11c.6 0 1-.4 1-1v-4.5m2.4-10a2 2 0 0 1 0 3l-6.8 6.8L8 14l.7-3.6 6.9-6.8a2 2 0 0 1 2.8 0Z"/>
                        </svg>
                    </a>
                </div>
            @endif
        </div>

@endforeach

<!-- Tooltips -->
    <div id="first" role="tooltip"
         class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
         style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1443px, 692px);"
         data-popper-placement="top">{{__("Projector status")}}
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
    <div id="second" role="tooltip"
         class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
         style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1443px, 692px);"
         data-popper-placement="top">{{__("Recording status")}}
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
    <div id="third" role="tooltip"
         class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
         style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1443px, 692px);"
         data-popper-placement="top">{{__("Room status")}}
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>

</div>
