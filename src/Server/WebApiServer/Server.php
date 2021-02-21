<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Server\WebApiServer;

use Hyperf\HttpMessage\Exception\UnsupportedMediaTypeHttpException;
use Hyperf\HttpMessage\Server\Response as Psr7Response;
use Hyperf\HttpServer\Contract\CoreMiddlewareInterface;
use Hyperf\Utils\Context;
use Psr\Http\Message\ResponseInterface;
use SmallSung\Hyperf\Server\WebApiServer\Error\Handler\ApiErrorHandler;

abstract class Server extends \SmallSung\Hyperf\Server\HttpServer\Server
{
    public function initCoreMiddleware(string $serverName): void
    {
        parent::initCoreMiddleware($serverName);
        $this->middlewares = array_merge([
            ApiErrorHandler::class,
        ], $this->middlewares);
    }

    protected function getDefaultExceptionHandler(): array
    {
        return array_merge([
            ApiErrorHandler::class,
        ], parent::getDefaultExceptionHandler());
    }

    protected function initRequestAndResponse($request, $response): array
    {
        /** @var \Swoole\Http\Request $request*/
        if (false === strpos($request->header['content-type'] ?? '', 'application/json')){
            Context::set(ResponseInterface::class, $psr7Response = new Psr7Response());
            throw new UnsupportedMediaTypeHttpException();
        }

        return parent::initRequestAndResponse($request, $response);
    }

    protected function createCoreMiddleware(): CoreMiddlewareInterface
    {
        return make(CoreMiddleware::class, [$this->container, $this->serverName]);
    }
}