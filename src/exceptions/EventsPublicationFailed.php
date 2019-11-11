<?php


namespace Lukasz93P\eventBus\exceptions;


use RuntimeException;
use Throwable;

class EventsPublicationFailed extends RuntimeException
{
    public static function fromReason(Throwable $reason): self
    {
        return new self("Events publication failed.", $reason->getCode(), $reason);
    }

    protected function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}