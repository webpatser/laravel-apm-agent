<?php

namespace Webpatser\LaravelApmAgent\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelApmAgent extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'APM';
    }
}
