<?php
declare(strict_types=1);


namespace Lukasz93P\tasksQueue\queue;


use Throwable;

interface AsynchronousQueue extends Queue
{
    /**
     * @param string $queueKey
     * @throws Throwable
     */
    public function startTasksProcessingLoop(string $queueKey): void;
}