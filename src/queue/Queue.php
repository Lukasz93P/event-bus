<?php


namespace Lukasz93P\tasksQueue\queue;


use Doctrine\Common\Collections\Collection;
use Lukasz93P\tasksQueue\AsynchronousTask;
use Lukasz93P\tasksQueue\queue\exceptions\EnqueuingFailed;
use Lukasz93P\tasksQueue\TaskHandler;

interface Queue
{
    public function register(TaskHandler $taskHandler, string $taskClassName): Queue;

    /**
     * @param Collection|AsynchronousTask[] $tasks
     * @throws EnqueuingFailed
     */
    public function enqueue(Collection $tasks): void;
}