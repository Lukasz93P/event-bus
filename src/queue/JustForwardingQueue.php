<?php


namespace Lukasz93P\tasksQueue\queue;


use Doctrine\Common\Collections\Collection;
use Lukasz93P\tasksQueue\AsynchronousTask;
use Lukasz93P\tasksQueue\queue\exceptions\EnqueuingFailed;
use Throwable;

class JustForwardingQueue extends BaseQueue implements Queue
{
    public function enqueue(Collection $tasks): void
    {
        foreach ($tasks as $event) {
            $this->handleEvent($event);
        }
    }

    private function handleEvent(AsynchronousTask $task): void
    {
        $handler = $this->findHandlerFor($task);
        if (!$handler) {
            return;
        }
        try {
            $handler->handle($task);
        } catch (Throwable $throwable) {
            throw EnqueuingFailed::fromReason($throwable);
        }
    }

}