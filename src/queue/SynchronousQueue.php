<?php
declare(strict_types=1);


namespace Lukasz93P\tasksQueue\queue;


use Lukasz93P\tasksQueue\PublishableAsynchronousTask;

class SynchronousQueue extends BaseQueue implements Queue
{
    public function enqueue(array $tasks): void
    {
        /** @var PublishableAsynchronousTask $task */
        foreach ($tasks as $task) {
            $this->handleTask($task);
        }
    }

}