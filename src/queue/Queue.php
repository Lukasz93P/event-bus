<?php
declare(strict_types=1);


namespace Lukasz93P\tasksQueue\queue;


use Lukasz93P\tasksQueue\AsynchronousTask;
use Lukasz93P\tasksQueue\queue\exceptions\EnqueuingFailed;
use Lukasz93P\tasksQueue\TaskHandler;

interface Queue
{
    public function register(TaskHandler $taskHandler, string $taskClassName): Queue;

    /**
     * @param AsynchronousTask[] $tasks
     * @throws EnqueuingFailed
     */
    public function enqueue(array $tasks): void;
}