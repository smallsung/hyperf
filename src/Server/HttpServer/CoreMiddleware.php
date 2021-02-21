<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Server\HttpServer;

use Psr\Container\ContainerInterface;

class CoreMiddleware extends \Hyperf\HttpServer\CoreMiddleware
{


    public function __construct(ContainerInterface $container, string $serverName)
    {
        parent::__construct($container, $serverName);
    }
}