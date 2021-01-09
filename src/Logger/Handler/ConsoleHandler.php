<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Logger\Handler;

use Monolog\Logger;
use Monolog\Processor\PsrLogMessageProcessor;

class ConsoleHandler extends StreamHandler
{
    public function __construct($level = Logger::DEBUG, bool $bubble = true, ?int $filePermission = null, bool $useLocking = false)
    {
        parent::__construct(STDOUT, $level, $bubble, $filePermission, $useLocking);
        $this->pushProcessor(new PsrLogMessageProcessor());
    }
}