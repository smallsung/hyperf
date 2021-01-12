<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Server\WebApiServer\Error;

class ParseError extends ApiErrorAbstract implements ApiErrorInterface
{
    public function getErrno(): int
    {
        return -32700;
    }

    public function getError(): string
    {
        return 'Parse error';
    }

    public function getErrorData()
    {
        return null;
    }
}