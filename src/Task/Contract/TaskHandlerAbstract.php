<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Task\Contract;

use Psr\Container\ContainerInterface;
use Swoole\Server;

abstract class TaskHandlerAbstract
{
    use HandlerTrait;

    protected int $workerId;
    protected int $taskId;
    protected int $flags;
    protected int $dispatchTime;

    abstract public function handle() : void ;

    public function setWorkerId(int $workerId): self
    {
        $this->workerId = $workerId;
        return $this;
    }

    public function setTaskId(int $taskId): self
    {
        $this->taskId = $taskId;
        return $this;
    }

    public function getWorkerId(): int
    {
        return $this->workerId;
    }

    public function getTaskId(): int
    {
        return $this->taskId;
    }

    public function getFlags(): int
    {
        return $this->flags;
    }

    public function setFlags(int $flags): self
    {
        $this->flags = $flags;
        return $this;
    }

    public function getDispatchTime(): int
    {
        return $this->dispatchTime;
    }

    public function setDispatchTime(int $dispatchTime): self
    {
        $this->dispatchTime = $dispatchTime;
        return $this;
    }
}