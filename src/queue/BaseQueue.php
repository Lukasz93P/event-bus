<?php
declare(strict_types=1);


namespace Lukasz93P\tasksQueue\queue;


use Lukasz93P\AsyncMessageChannel\exceptions\MessageConstantlyUnprocessable;
use Lukasz93P\tasksQueue\ProcessableAsynchronousTask;
use Lukasz93P\tasksQueue\queue\exceptions\TaskConstantlyUnprocessable;
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

    protected function handleTask(ProcessableAsynchronousTask $task): void
    {
        $handler = $this->findHandlerFor($task);
        if (!$handler) {
            return;
        }
        try {
            $handler->handle($task);
        } catch (TaskConstantlyUnprocessable $taskConstantlyUnprocessable) {
            throw MessageConstantlyUnprocessable::fromReason($taskConstantlyUnprocessable);
        }
    }

    private function findHandlerFor(ProcessableAsynchronousTask $task): ?TaskHandler
    {
        return $this->registeredHandlers[get_class($task)] ?? null;
    }

}