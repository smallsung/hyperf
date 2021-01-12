<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Server\WebApiServer\Error;

class ApiError extends ApiErrorAbstract implements ApiErrorInterface
{
    protected int $errno;
    protected string $error;

    public function __construct(int $errno = -1, string $error = '', $errorData = null)
    {
        $this->errno = $errno;
        $this->error = $error;
        $this->errorData = $errorData;
        parent::__construct();
    }

    public function getErrno(): int
    {
        return $this->errno;
    }

    public function getError(): string
    {
        return $this->error;
    }

    public function getErrorData()
    {
        return $this->errorData;
    }
}