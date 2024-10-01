{{--}}
@php
    $file = base_path().'/systemconfig/internt.ini';
    if (!file_exists($file)) {
        $file = base_path().'/systemconfig/internt.ini.example';
        }
    $system_config = parse_ini_file($file, true);
@endphp
@antlers
<video
    controls
    playsinline="1"
    preload="auto"
    crossorigin="anonymous"
    src="https://play-store-prod.dsv.su.se/presentation/13315a63-bd19-441b-bbe7-bc6c8cd0b1be/833835730-720.mp4?token={{ $system_config['play']['token'] }}">
</video>
@endantlers
{{--}}

<p class="bg-clip-text bg-gradient-to-l from-purple-400 to-blue-600 text-transparent text-xs font-semibold uppercase dark:from-blue-500 dark:to-white">
    {{__("Scheduled for launch,")}}
</p>
<span class="bg-clip-text bg-gradient-to-l from-purple-400 to-blue-600 text-transparent text-7xl font-bold dark:from-blue-500 dark:to-white">
                                2024
                            </span>
<h3 class="mt-6 text-lg md:text-xl font-semibold text-gray-800 dark:text-gray-200">
    DSV Intranet
</h3>
<p class="mt-2 text-gray-500 dark:text-gray-200">
    {{__("The DSV Intranet website is under construction.")}}
</p>
