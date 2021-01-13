<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Task\Contract;

abstract class FinishHandlerAbstract
{
    use HandlerTrait;

    protected int $taskId;

    abstract public function handle() :void ;

    public function getTaskId(): int
    {
        return $this->taskId;
    }

    public function setTaskId(int $taskId): self
    {
        $this->taskId = $taskId;
        return $this;
    }
}