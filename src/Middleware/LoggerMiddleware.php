<?php

namespace Namaa\Logstash\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoggerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $data = [
            'http' => [
                'version' => $_SERVER['SERVER_PROTOCOL'],
                'request' => [
                    'method' => $request->getMethod(),
                    'headers' => $request->headers->all()
                ],
                'response' => [],
            ],
            'client' => [
                'ip' => $request->ip(),
            ],
            'url' => [
                'domain' => $request->getHost(),
                'full' => url()->current(),
                'path' => $request->path()
            ],
            'event'=>[
                'dataset'=>'Dashboard'
            ]
        ];


        // if request if authenticated
        if ($request->user()) {
            $data['client']['user']['id'] = $request->user()->id;
            $data['client']['user']['name'] = $request->user()->name;
        }

        // if you want to log all the request body
        if (count($request->all()) > 0) {
            // keys to skip like password or any sensitive information
            $hiddenKeys = ['password'];

            $data['http']['request']['body']['content'] = $request->except($hiddenKeys);
            $data['http']['request']['body']['bytes'] = intval($_SERVER['CONTENT_LENGTH']);
        }


        $response = $next($request);
        $data['http']['response']['status_code'] = $response->getStatusCode();
        $data['http']['response']['headers'] = $response->headers->all();

        // log the gathered information
        if($response->getStatusCode()>=500){
            Log::error('http request', $data);
        }else{
            Log::info('http request', $data);
        }


        // return the response
        return $response;
    }
}
