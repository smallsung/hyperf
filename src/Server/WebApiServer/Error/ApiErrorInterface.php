<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Server\WebApiServer\Error;

interface ApiErrorInterface extends \Throwable
{
    public function getErrno(): int;
    public function getError(): string ;
    public function getErrorData();
    public function getHttpStatusCode(): int;
    public function toError(): array;
    public function getLogLevel(): ?string;
}