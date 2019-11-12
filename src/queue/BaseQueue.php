<?php


namespace Lukasz93P\tasksQueue\queue;


use Lukasz93P\tasksQueue\AsynchronousTask;
use Lukasz93P\tasksQueue\TaskHandler;

abstract class BaseQueue implements Queue
{
    /**
     * @var TaskHandler[]
     */
    private $registeredHandlers = [];

    public function register(TaskHandler $taskHandler, string $taskClassName): Queue
    {
        $this->registeredHandlers[$taskClassName] = $taskHandler;

        return $this;
    }

    protected function findHandlerFor(AsynchronousTask $task): ?TaskHandler
    {
        return $this->registeredHandlers[get_class($task)] ?? null;
    }

}