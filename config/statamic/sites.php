<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sites
    |--------------------------------------------------------------------------
    |
    | Each site should have root URL that is either relative or absolute. Sites
    | are typically used for localization (eg. English/French) but may also
    | be used for related content (eg. different franchise locations).
    |
    */

    'sites' => [

        'English' => [
            //'name' => config('app.name'),
            'name' => 'English',
            'locale' => 'en_US',
            //'url' => '/',
            'url' => env('APP_URL'),
        ],

        'swe' => [
            'name' => 'Svenska',
            'locale' => 'sv_SE',
            //'url' => '/swe/',
            'url' => env('APP_URL') . 'swe/',
        ],

    ],
];
