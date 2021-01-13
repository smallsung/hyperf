<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Task;

use Closure;
use SmallSung\Hyperf\Task\Contract\TaskHandlerAbstract;

class ClosureTaskHandler extends TaskHandlerAbstract
{
    protected string $closureSerialize;

    public function __construct(Closure $closure)
    {
        $this->closureSerialize = \Opis\Closure\serialize($closure);
    }

    public function handle(): void
    {
        $closure = \Opis\Closure\unserialize($this->closureSerialize);
        $result = call_user_func($closure, ...func_get_args());

        $this->getServer()->finish($result);
    }
}