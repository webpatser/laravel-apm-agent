<?php

namespace Webpatser\LaravelApmAgent\Providers;

use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Webpatser\LaravelApmAgent\Apm;
use Webpatser\LaravelApmAgent\Middleware\Trace;
use Webpatser\LaravelApmAgent\Models\Metadata;
use Webpatser\LaravelApmAgent\Models\Transaction;


class LaravelApmAgentServiceProvider extends ServiceProvider
{
    protected $spans = [];

    protected $apm = [];

    /**
     * Bootstrap services.
     *
     * @param Dispatcher $events
     *
     * @return void
     */
    public function boot()
    {

        $this->app->singleton('apm', function() {
            return new Apm();
        });

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

}
