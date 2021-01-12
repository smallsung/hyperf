<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Server\WebApiServer;

use Hyperf\Utils\Contracts\Jsonable;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use function SmallSung\Hyperf\jsonDecode;

class CoreMiddleware extends \SmallSung\Hyperf\Server\HttpServer\CoreMiddleware
{
    protected ResponseBuilder $responseBuilder;

    public function __construct(ContainerInterface $container, string $serverName)
    {
        parent::__construct($container, $serverName);
        $this->responseBuilder = $this->container->get(ResponseBuilder::class);
    }

    protected function transferToResponse($response, ServerRequestInterface $request): ResponseInterface
    {
        if ($response instanceof Jsonable){
            $response = jsonDecode($response);
        }
        return $this->responseBuilder->buildResponse($response, $this->response());
    }
}