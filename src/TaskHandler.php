<?php
declare(strict_types=1);


namespace Lukasz93P\tasksQueue;


use Lukasz93P\tasksQueue\queue\exceptions\TaskConstantlyUnprocessable;

interface TaskHandler
{
    /**
     * @param AsynchronousTask $task
     * @throws TaskConstantlyUnprocessable
     */
    public function handle(AsynchronousTask $task): void;
}