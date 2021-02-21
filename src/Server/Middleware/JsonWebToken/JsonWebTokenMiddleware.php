<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Server\Middleware\JsonWebToken;

use Hyperf\HttpMessage\Exception\UnauthorizedHttpException;
use Hyperf\Utils\Context;
use Lcobucci\JWT\Token;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class JsonWebTokenMiddleware implements MiddlewareInterface
{
    protected Parser $jsonWebTokenParser;
    protected Storage $storage;

    public function __construct(ContainerInterface $container)
    {
        $this->jsonWebTokenParser = $container->get(Parser::class);
        $this->storage = $container->get(Storage::class);
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $authorization = $request->getHeaderLine('Authorization');

        $this->tokenExist($authorization);
        $token = $this->parseToken($authorization);
        Context::set(JsonWebToken::class, $token);

        return $handler->handle($request);
    }

    protected function tokenExist(string $token): void
    {
        if (!$this->storage->exist($token)){
            throw new UnauthorizedHttpException();
        }
    }

    protected function parseToken(string $tokenString): Token
    {
        try {
            return $this->jsonWebTokenParser->parse($tokenString);
        }catch (\Exception $exception){
            throw new UnauthorizedHttpException();
        }
    }
}