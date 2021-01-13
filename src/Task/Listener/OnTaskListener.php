<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Task\Listener;

use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Framework\Event\OnTask;
use Psr\Container\ContainerInterface;
use SmallSung\Hyperf\Task\Contract\FinishHandlerAbstract;
use SmallSung\Hyperf\Task\Package;

/**
 * @Listener()
 */
class OnTaskListener implements ListenerInterface
{
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function listen(): array
    {
        return [
            OnTask::class,
        ];
    }

    public function process(object $event)
    {
        try {
            /** @var OnTask $event */
            if (!($event->task->data instanceof Package)){
                return ;
            }

            /** @var Package $package */
            $package = $event->task->data;

            $package->getTaskHandler()
                ->setContainer($this->container)
                ->setServer($event->server)
                ->setWorkerId($event->task->worker_id)
                ->setTaskId($event->task->id)
                ->handle();

            $finishHandler = $package->getFinishHandler();
            if (!$finishHandler instanceof FinishHandlerAbstract){
                return;
            }

            $event->server->finish($finishHandler);
        }catch (\Throwable $throwable){
            throw $throwable;
        }
    }
}