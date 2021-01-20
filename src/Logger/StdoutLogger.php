<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Logger;

use Psr\Container\ContainerInterface;

class StdoutLogger
{
    public function __invoke(ContainerInterface $container)
    {
        return $container->get(\Hyperf\Logger\LoggerFactory::class)->get('', static::class);
    }
}