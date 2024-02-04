<?php
return [
    'host' => env('LOGSTASH_HOST', '127.0.0.1'),
    'port' => env('LOGSTASH_PORT', 50000),
    'enableRequestResponseLogging' => env('LOGSTASH_ENABLE_REQUEST_RESPONSE_LOGGING', true)

];
