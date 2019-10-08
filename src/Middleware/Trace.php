<?php

namespace Webpatser\LaravelApmAgent\Middleware;

use App;
use Closure;
use Webpatser\LaravelApmAgent\Apm;

class Trace
{

    /** @var Apm */
    protected $agent;

    public function __construct()
    {
        $this->agent = App::make('apm');
    }

    /**
     * [handle description]
     * @param  Request $request [description]
     * @param  Closure $next [description]
     * @return [type]           [description]
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        return $response;
    }
    /**
     * Perform any final actions for the request lifecycle.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Symfony\Component\HttpFoundation\Response $response
     *
     * @return void
     */
    public function terminate($request, $response)
    {
        if (config('APM_ACTIVE', false)) {
            //$this->agent->endMain();
            $this->agent->send();
        }
    }
}
