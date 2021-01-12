<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Server\WebApiServer\Error\Handler;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use SmallSung\Hyperf\Server\WebApiServer\Error\ApiErrorInterface;
use SmallSung\Hyperf\Server\WebApiServer\ResponseBuilder;
use Throwable;

class ApiErrorHandler extends ExceptionHandler
{
    protected LoggerInterface $logger;
    protected ResponseBuilder $responseBuilder;

    public function __construct(StdoutLoggerInterface $logger, ResponseBuilder $responseBuilder)
    {
        $this->logger = $logger;
        $this->responseBuilder = $responseBuilder;
    }

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        /** @var ApiErrorInterface $throwable */
        if ($logLevel = $throwable->getLogLevel()){
            $this->logger->{$logLevel}($this->format($throwable));
        }
        $this->stopPropagation();

        return $this->responseBuilder->buildErrorResponse($throwable, $response);
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ApiErrorInterface;
    }

    protected function format(ApiErrorInterface $apiError): string
    {
        return sprintf(
            "%s\t%s:%s [%s][%s]"
            ,get_class($apiError)
            ,$apiError->getFile()
            ,$apiError->getLogLevel()
            ,$apiError->getErrno()
            ,$apiError->getError()
        );
    }
}