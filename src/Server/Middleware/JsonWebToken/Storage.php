<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Server\Middleware\JsonWebToken;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\RedisFactory;
use Hyperf\Redis\RedisProxy;
use Psr\Container\ContainerInterface;
use SmallSung\Hyperf\Exception\RuntimeException;

class Storage
{
    /**
     * @Inject()
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    protected ?string $jsonWebTokenPoolName = null;

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

    protected function getRedis(): ?RedisProxy
    {
        if (is_null($this->jsonWebTokenPoolName)){
            $this->jsonWebTokenPoolName = $this->container->get(ConfigInterface::class)->get('jsonWebToken.pool', '');
        }

        if ('' === $this->jsonWebTokenPoolName){
            return $this->container->get(RedisFactory::class)->get($this->jsonWebTokenPoolName);
        }
        return null;
    }

    protected function hashToken(string $token): string
    {
        return md5($token, false);
    }
}