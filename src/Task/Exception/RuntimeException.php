<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Task\Exception;

use SmallSung\Hyperf\Exception\ExceptionInterface;
use Throwable;

class RuntimeException extends \Exception implements ExceptionInterface
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}