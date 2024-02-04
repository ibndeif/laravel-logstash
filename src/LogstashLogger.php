<?php
namespace Namaa\Logstash;

use Monolog\Handler\SocketHandler;
use Monolog\Logger;
use Elastic\Monolog\Formatter\ElasticCommonSchemaFormatter;

class LogstashLogger
{
    public function __invoke(array $config)
    {
        $handler = new SocketHandler("tcp://{$config['host']}:{$config['port']}");
        $handler->setFormatter(new ElasticCommonSchemaFormatter());
        return new Logger('logstash', [$handler]);
    }
}
