<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Server\Middleware\JsonWebToken;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Redis\RedisFactory;
use Hyperf\Redis\RedisProxy;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use SmallSung\Hyperf\Exception\RuntimeException;

class Storage
{
    protected ContainerInterface $container;

    protected string $jsonWebTokenRedisPoolName;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->initStorage();
    }

    public function exist(string $token): bool
    {
        if (empty($token)){
            return false;
        }
        if (is_null($storage = $this->getStorage())){
            return true;
        }
        return boolval($storage->exists($this->hashToken($token)));
    }

    public function store(string $token, int $timeout): void
    {
        if (is_null($storage = $this->getStorage())){
            throw new RuntimeException('未定义存储');
        }
        $storage->set($this->hashToken($token), null, $timeout);
    }

    protected function getStorage()
    {
        return $this->getRedis();
    }

    protected function initStorage(): void
    {
        $this->initRedis();
    }

    protected function getRedis(): ?RedisProxy
    {
        return empty($this->jsonWebTokenRedisPoolName) ? null : $this->container->get(RedisFactory::class)->get($this->jsonWebTokenRedisPoolName);
    }

    protected function initRedis(): void
    {
        if (empty($this->jsonWebTokenRedisPoolName = $this->container->get(ConfigInterface::class)->get('jsonWebToken.pool', ''))){
            $this->container->get(LoggerInterface::class)->warning('config.jsonWebToken.pool 未定义。不检查jsonWebToken！');
        }
    }

    protected function hashToken(string $token): string
    {
        return md5($token, false);
    }
}