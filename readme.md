# Laravel Logstash
Format logs using [ECS](https://www.elastic.co/guide/en/ecs/current/ecs-reference.html) and sending it to Logstash over tcp.

## Installation
```
composer require deif/logstash
```

## Configurations
- LOG_CHANNEL=logstash
- LOGSTASH_HOST=127.0.0.1
- LOGSTASH_PORT=50000
- LOGSTASH_ENABLE_REQUEST_RESPONSE_LOGGING=true


## Notes
use v1.1 with laravel 8
