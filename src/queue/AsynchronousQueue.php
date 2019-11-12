<?php


namespace Lukasz93P\tasksQueue\queue;


use ErrorException;

interface AsynchronousQueue extends Queue
{
    /**
     * @param string $queueKey
     * @throws ErrorException
     */
    public function startTasksProcessingLoop(string $queueKey): void;
}