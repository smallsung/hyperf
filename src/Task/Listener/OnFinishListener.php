<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Task\Listener;

use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Framework\Event\OnFinish;
use Psr\Container\ContainerInterface;
use SmallSung\Hyperf\Task\Contract\FinishHandlerAbstract;

/**
 * @Listener()
 */
class OnFinishListener implements ListenerInterface
{
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function listen(): array
    {
        return [
            OnFinish::class,
        ];
    }

    public function process(object $event)
    {
        try {
            /** @var OnFinish $event*/
            if (!($event->data instanceof FinishHandlerAbstract)){
                return ;
            }
            /** @var FinishHandlerAbstract $finishHandler */
            $finishHandler = $event->data;
            $finishHandler->setContainer($this->container)
                ->setServer($event->server)
                ->setTaskId($event->taskId);
        }catch (\Throwable $throwable){
            throw $throwable;
        }
    }

}