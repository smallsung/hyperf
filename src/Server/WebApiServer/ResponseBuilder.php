<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Server\WebApiServer;

use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Context;
use Psr\Http\Message\ResponseInterface;
use SmallSung\Hyperf\Server\WebApiServer\Error\ApiErrorInterface;
use function SmallSung\Hyperf\jsonEncode;

class ResponseBuilder
{
    public function buildResponse($result, ?ResponseInterface $response = null): ResponseInterface
    {
        $response ??= $this->response();
        return $response->withStatus(200)
            ->withAddedHeader('content-type', 'application/json')
            ->withBody(new SwooleStream($this->formatResponse($result)));
    }

    protected function formatResponse($result)
    {
        return jsonEncode([
            'result'=>$result
        ]);
    }

    public function buildErrorResponse(ApiErrorInterface $apiError, ?ResponseInterface $response = null): ResponseInterface
    {
        $response ??= $this->response();

        return $response->withStatus($apiError->getHttpStatusCode())
            ->withAddedHeader('content-type', 'application/json')
            ->withBody(new SwooleStream($this->formatErrorResponse($apiError)));
    }

    protected function formatErrorResponse(ApiErrorInterface $apiError): string
    {
        return jsonEncode([
            'error'=>$apiError->toError(),
        ]);
    }

    protected function response(): ResponseInterface
    {
        return Context::get(ResponseInterface::class);
    }
}