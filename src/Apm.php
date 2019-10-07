<?php

namespace Webpatser\LaravelApmAgent;

use Event;
use GuzzleHttp\Client;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Swaggest\JsonSchema\Schema;
use Webpatser\LaravelApmAgent\Models\Metadata;
use Webpatser\LaravelApmAgent\Models\Transaction;

class Apm
{

    /**
     * @var array
     */
    protected $apm = [];

    public function __construct()
    {
        Event::listen(RequestHandled::class, [$this, 'recordRequest']);
        Event::listen('bootstrapped: *', [$this, 'bootstrapped']);

        $this->apm[] = new Metadata();
        $this->apm[] = new Transaction();

//        $schema = Schema::import('https://raw.githubusercontent.com/webpatser/apm-server/master/docs/spec/metadata.json');
//
//        $schema->in(json_decode(json_encode($data->toArray())));
        //$schema->in(json_decode('{"process": {"pid": 1234}, "system": {"container": {"id": "container-id"}, "kubernetes": {"namespace": "namespace1", "pod": {"uid": "pod-uid", "name": "pod-name"}, "node": {"name": "node-name"}}}, "service": {"name": "1234_service-12a3", "language": {"name": "ecmascript"}, "agent": {"version": "3.14.0", "name": "elastic-node"}, "framework": {"name": "emac"}}}'));
    }


    public function bootstrapped($event)
    {
        $this->apm[] = new Metadata();
    }

    public function endMain()
    {
        $this->apm[] = new Transaction();
    }

    /**
     * Record an incoming HTTP request.
     *
     * @param  \Illuminate\Foundation\Http\Events\RequestHandled  $event
     * @return void
     */
    public function recordRequest(RequestHandled $event)
    {

    }

    public function send()
    {
        $body = implode(PHP_EOL, $this->apm);
        $client = new Client();

        $response = $client->post(config('apm.url') . '/intake/v2/events', [
            'headers' => [
                'Authorization' => 'Bearer ' . config('apm.token'),
                'Content-Type' => 'application/x-ndjson',
                'User-Agent'=> 'laravel-apm-agent/0.1',
                'Accept' => 'application/json',
            ],
            'body'    => $body,
        ]);

        return ($response->getStatusCode() >= 202 && $response->getStatusCode() < 300);
    }
}
