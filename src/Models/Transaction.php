<?php

namespace Webpatser\LaravelApmAgent\Models;

use Illuminate\Support\Collection;

class Transaction extends Collection
{
    /**
     * Create a new collection.
     *
     * @param  mixed  $items
     * @return void
     */
    public function __construct($items = [])
    {
        $startTime = defined('LARAVEL_START') ? LARAVEL_START : $event->request->server('REQUEST_TIME_FLOAT');

        $this->items = [
            'transaction' => [
                'trace_id' => bin2hex(random_bytes(16)),
                'id' => bin2hex(random_bytes(8)),
                'type' => 'request',
                'duration' => $startTime ? (microtime(true) - $startTime) * 1000 : null,
                'result' => "200",
                'context' => null,
                'spans' => null,
                'sampled' => null,
                'name' => "fnctn-qr",
                'span_count' => [
                    'started' => 0
                ],
            ]
        ];
    }
}
