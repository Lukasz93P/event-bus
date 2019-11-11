<?php


namespace Lukasz93P\eventBus\serializableMessageConverter\exceptions;


use Lukasz93P\AsyncMessageChannel\Message;
use Lukasz93P\objectSerializer\SerializableObject;
use RuntimeException;
use Throwable;

class ConversionFailed extends RuntimeException
{
    public static function fromReason(Throwable $reason): self
    {
        return new self('Converion beetwen ' . SerializableObject::class . ' and ' . Message::class . ' failed.', $reason->getCode(), $reason);
    }

    private function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}