<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Server\WebApiServer\Error;

use Psr\Log\LogLevel;

abstract class ApiErrorAbstract extends \Exception implements ApiErrorInterface
{
    /**
     * @var mixed
     */
    protected $errorData = null;

    public function setErrorData($errorData): self
    {
        $this->errorData = $errorData;
        return $this;
    }

    public function getHttpStatusCode(): int
    {
        return 200;
    }

    public function getLogLevel(): ?string
    {
        return LogLevel::DEBUG;
    }

    public function toError(): array
    {
        return [
            'code'=>$this->getErrno(),
            'message'=>$this->getError(),
            'data'=>$this->getErrorData(),
        ];
    }
}