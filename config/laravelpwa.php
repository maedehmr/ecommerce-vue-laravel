<?php

return [
    'name' => 'LaravelPWA',
    'manifest' => [
        'name' => env('APP_NAME', 'cisco'),
        'short_name' => 'cisco',
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'orientation'=> 'any',
        'status_bar'=> 'black',
        'icons' => [
            '72x72' => [
                'path' => '/pwa/icon-72x72.png',
                'sizes' =>	"72x72",
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '/pwa/icon-96x96.png',
                'sizes' =>	"96x96",
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => '/pwa/icon-128x128.png',
                'sizes' =>	"128x128",
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '/pwa/icon-144x144.png',
                'sizes' =>	"144x144",
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => '/pwa/icon-152x152.png',
                'sizes' =>	"152x152",
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/pwa/icon-192x192.png',
                'sizes' =>	"192x192",
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => '/pwa/icon-384x384.png',
                'sizes' =>	"384x384",
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/pwa/icon-512x512.png',
                'sizes' =>	"512x512",
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => '/pwa/splash-640x1136.png',
            '750x1334' => '/pwa/splash-750x1334.png',
            '828x1792' => '/pwa/splash-828x1792.png',
            '1125x2436' => '/pwa/splash-1125x2436.png',
            '1242x2208' => '/pwa/splash-1242x2208.png',
            '1242x2688' => '/pwa/splash-1242x2688.png',
            '1536x2048' => '/pwa/splash-1536x2048.png',
            '1668x2224' => '/pwa/splash-1668x2224.png',
            '1668x2388' => '/pwa/splash-1668x2388.png',
            '2048x2732' => '/pwa/splash-2048x2732.png',
        ],
        'shortcuts' => [
            [
                'name' => 'cisco',
                'description' => 'فروشگاه تجهیزات سیسکو',
                'url' => '/',
                'icons' => [
                    "src" => "/pwa/icon-72x72.png",
                    "purpose" => "any"
                ]
            ],
            [
                'name' => 'cisco',
                'description' => 'فروشگاه تجهیزات سیسکو',
                'url' => '/'
            ]
        ],
        'custom' => []
    ]
];
