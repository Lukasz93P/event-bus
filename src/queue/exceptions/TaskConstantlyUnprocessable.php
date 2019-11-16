<?php
declare(strict_types=1);


namespace Lukasz93P\tasksQueue\queue\exceptions;


use Lukasz93P\tasksQueue\AsynchronousTask;
use Throwable;

class TaskConstantlyUnprocessable extends AsynchronousQueueException
{
    /**
     * @var AsynchronousTask
     */
    private $task;

    public static function fromTask(AsynchronousTask $task): self
    {
        return new self($task, "Task was marked as constantly unprocessable and it will not be processed again.");
    }

    private function __construct(AsynchronousTask $task, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->task = $task;
    }

    public function task(): AsynchronousTask
    {
        return $this->task;
    }

}