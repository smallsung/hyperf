<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Server\HttpServer;

use Hyperf\HttpServer\Contract\CoreMiddlewareInterface;

abstract class Server extends \Hyperf\HttpServer\Server
{
    protected function createCoreMiddleware(): CoreMiddlewareInterface
    {
        return make(CoreMiddleware::class, [$this->container, $this->serverName]);
    }
}