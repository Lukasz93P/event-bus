<?php
declare(strict_types=1);


namespace Lukasz93P\tasksQueue\queue\exceptions;


use Lukasz93P\tasksQueue\ProcessableAsynchronousTask;
use Throwable;

class TaskConstantlyUnprocessable extends AsynchronousQueueException
{
    /**
     * @var ProcessableAsynchronousTask
     */
    private $task;

    public static function fromTask(ProcessableAsynchronousTask $task): self
    {
        return new self($task, "Task was marked as constantly unprocessable and it will not be processed again.");
    }

    private function __construct(ProcessableAsynchronousTask $task, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->task = $task;
    }

    public function task(): ProcessableAsynchronousTask
    {
        return $this->task;
    }

}