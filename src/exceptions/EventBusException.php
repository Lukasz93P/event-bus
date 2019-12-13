<?php
declare(strict_types=1);


namespace Lukasz93P\EventBus\exceptions;


use RuntimeException;
use Throwable;

abstract class EventBusException extends RuntimeException
{
    public static function fromReason(Throwable $reason): self
    {
        return new static(static::generateBaseMessage() . PHP_EOL . 'Reason:' . $reason->getMessage() . PHP_EOL . PHP_EOL, $reason->getCode(), $reason);
    }

    protected function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message , $code, $previous);
    }

    abstract protected static function generateBaseMessage(): string;
}