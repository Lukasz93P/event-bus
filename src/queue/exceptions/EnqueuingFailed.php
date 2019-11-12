<?php


namespace Lukasz93P\tasksQueue\queue\exceptions;


use RuntimeException;
use Throwable;

class EnqueuingFailed extends RuntimeException
{
    public static function fromReason(Throwable $reason): self
    {
        return new self("Tasks enqueuing failed.", $reason->getCode(), $reason);
    }

    protected function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}