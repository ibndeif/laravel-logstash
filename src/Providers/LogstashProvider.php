<?php
namespace Namaa\Logstash\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Log;

use Namaa\Logstash\LogstashLogger;
use Namaa\Logstash\Middleware\LoggerMiddleware;

class LogstashProvider extends ServiceProvider
{
    public function boot(Kernel $kernel)
    {


        // add some fields to logger
        Log::withContext([
            'service'=>['name'=>config('app.name'), 'environment'=>config('app.env')],
            'event'=>['dataset'=>config('app.name')]
        ]);

        // apply request response logging middleware
        if(config('logstash.enableRequestResponseLogging')){
            $kernel->prependMiddleware(LoggerMiddleware::class);
        }
    }

    public function register()
    { // merge configs
        $this->mergeConfigFrom(__DIR__.'/../config/logstash.php', 'logstash');

        $this->app->make('config')->set('logging.channels.logstash', [
            'driver' => 'custom',
            'via' =>LogstashLogger::class,
            'host' => config('logstash.host'),
            'port' => config('logstash.port'),
        ]);
    }
}
