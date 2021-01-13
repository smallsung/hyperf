<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Task\Exception;

use SmallSung\Hyperf\Exception\ExceptionInterface;

class InvalidArgumentException extends \InvalidArgumentException implements ExceptionInterface
{

}