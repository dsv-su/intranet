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
<livewire:stats-user-registration />
