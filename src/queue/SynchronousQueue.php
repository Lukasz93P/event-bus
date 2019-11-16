<?php
declare(strict_types=1);


namespace Lukasz93P\tasksQueue\queue;


class SynchronousQueue extends BaseQueue implements Queue
{
    public function enqueue(array $tasks): void
    {
        foreach ($tasks as $task) {
            $this->handleTask($task);
        }
    }

}