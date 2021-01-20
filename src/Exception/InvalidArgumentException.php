<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Exception;

use Throwable;

class InvalidArgumentException extends \InvalidArgumentException implements ExceptionInterface
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}