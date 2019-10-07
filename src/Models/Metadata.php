<?php

namespace Webpatser\LaravelApmAgent\Models;

use Illuminate\Support\Collection;

class Metadata extends Collection
{
    /**
     * Create a new collection.
     *
     * @param  mixed  $items
     * @return void
     */
    public function __construct($items = [])
    {
        $this->items = [
            'metadata' => [
                'service' => [
                    'name'    => config('appName'),
                    'version' => config('appVersion'),
                    'framework' => [
                        'name' => 'laravel',
                        'version' => '6.1.0',
                    ],
                    'language' => [
                        'name'    => 'php',
                        'version' => phpversion()
                    ],

                    'agent' => [
                        'name'    => 'laravel-apm-agent',
                        'version' => '0.1'
                    ],
                    'environment' => 'production'
                ],
                'process' => [
                    'pid' => getmypid(),
                ],
                'system' => [
                    'hostname'     => config('hostname'),
                    'architecture' => php_uname('m'),
                    'platform'     => php_uname('s')
                ],
                'user' => null,
                'labels' => null,
        ]
        ];
    }
}
