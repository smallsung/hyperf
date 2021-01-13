<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Task;

use Closure;
use Psr\Container\ContainerInterface;
use SmallSung\Hyperf\Task\Contract\FinishHandlerAbstract;
use SmallSung\Hyperf\Task\Contract\TaskHandlerAbstract;
use SmallSung\Hyperf\Task\Exception\InvalidArgumentException;
use SmallSung\Hyperf\Task\Exception\RuntimeException;
use Swoole\Server;

class TaskManager
{
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param Closure|TaskHandlerAbstract $task
     * @param Closure|FinishHandlerAbstract|null $finishHandler
     * @param int $dstWorkerId
     * @return int
     * @throws RuntimeException
     */
    public function async($task, $finishHandler = null, int $dstWorkerId = -1): int
    {
        if ($task instanceof Closure){
            $task = new ClosureTaskHandler($task);
        }
        if (! $task instanceof TaskHandlerAbstract){
            throw new InvalidArgumentException();
        }

        $package = new Package();
        $package->setTaskHandler($task);

        if ($finishHandler instanceof FinishHandlerAbstract){
            $package->setFinishHandler($finishHandler);
            $finishHandler = null;
        }
        if ((! $finishHandler instanceof Closure) && (! is_null($finishHandler))){
            throw new InvalidArgumentException();
        }

        $taskId = $this->container->get(Server::class)->task($package, $dstWorkerId, $finishHandler);
        if (false === $taskId){
            throw new RuntimeException();
        }
        return $taskId;
    }
}