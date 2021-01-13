<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Task;

use SmallSung\Hyperf\Task\Contract\FinishHandlerAbstract;
use SmallSung\Hyperf\Task\Contract\TaskHandlerAbstract;

class Package
{
    protected TaskHandlerAbstract $taskHandler;
    protected ?FinishHandlerAbstract $finishHandler = null;

    public function getTaskHandler(): TaskHandlerAbstract
    {
        return $this->taskHandler;
    }

    public function setTaskHandler(TaskHandlerAbstract $taskHandler): self
    {
        $this->taskHandler = $taskHandler;
        return $this;
    }

    public function getFinishHandler(): ?FinishHandlerAbstract
    {
        return $this->finishHandler;
    }

    public function setFinishHandler(?FinishHandlerAbstract $finishHandler): self
    {
        $this->finishHandler = $finishHandler;
        return $this;
    }
}