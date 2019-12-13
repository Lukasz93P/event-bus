<?php
declare(strict_types=1);


namespace Lukasz93P\EventBus\exceptions;


use RuntimeException;
use Throwable;

abstract class EventBusException extends RuntimeException
{
    public static function fromReason(Throwable $reason)
    {
        return new static(static::message() . PHP_EOL . 'Reason:' . $reason->getMessage() . PHP_EOL . PHP_EOL, $reason->getCode(), $reason);
    }

    protected function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message . PHP_EOL . $previous->getMessage(), $code, $previous);
    }

    abstract protected static function message(): string;
}