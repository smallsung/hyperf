<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Task\Contract;

use Psr\Container\ContainerInterface;
use Swoole\Server;

trait HandlerTrait
{
    protected ContainerInterface $container;
    protected Server $server;

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    public function setContainer(ContainerInterface $container): self
    {
        $this->container = $container;
        return $this;
    }

    public function getServer(): Server
    {
        return $this->server;
    }

    public function setServer(Server $server): self
    {
        $this->server = $server;
        return $this;
    }
}