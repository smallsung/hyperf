<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Server\Middleware\JsonWebToken;

use Hyperf\Utils\Context;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\Token\Plain;
use Psr\Container\ContainerInterface;

/**
 * @mixin Plain
 */
class JsonWebToken
{
    protected ContainerInterface $container;
    protected Generator $generator;

    public function __construct(ContainerInterface $container)
    {
        $this->generator = $container->get(Generator::class);
    }

    public function __call($name, $arguments)
    {
        return $this->getToken()->{$name}(...$arguments);
    }

    public function getToken(): Token
    {
        $token = Context::get(static::class, null);
        if (is_null($token)){
            $token = $this->generator->generate();
        }
        return $token;
    }
}