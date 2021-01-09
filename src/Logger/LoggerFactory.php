<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Logger;

use Hyperf\Logger\LoggerFactory as HyperfLoggerFactory;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class LoggerFactory
{
    const DEFAULT_GROUP_NAME = 'default:smallsung';

    protected HyperfLoggerFactory $hyperfLoggerFactory;

    public function __construct(ContainerInterface $container)
    {
        $this->hyperfLoggerFactory = new HyperfLoggerFactory($container);
    }

    public function get(...$args): LoggerInterface
    {
        return $this->hyperfLoggerFactory->get(...$args);
    }

    public function make(...$args): LoggerInterface
    {
        return $this->hyperfLoggerFactory->make(...$args);
    }
}