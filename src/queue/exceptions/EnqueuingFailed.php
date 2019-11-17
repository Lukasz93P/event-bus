<?php
declare(strict_types=1);


namespace Lukasz93P\tasksQueue\queue\exceptions;


use Throwable;

class EnqueuingFailed extends AsynchronousQueueException
{
    public static function fromReason(Throwable $reason): self
    {
        return new self("Tasks enqueuing failed. Reason:" . PHP_EOL . $reason->getMessage(), $reason->getCode(), $reason);
    }

}