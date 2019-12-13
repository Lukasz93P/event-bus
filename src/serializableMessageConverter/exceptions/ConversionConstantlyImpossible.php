<?php
declare(strict_types=1);


namespace Lukasz93P\tasksQueue\serializableMessageConverter\exceptions;


use Lukasz93P\AsyncMessageChannel\ProcessableMessage;
use Lukasz93P\objectSerializer\SerializableObject;
use RuntimeException;
use Throwable;

class ConversionConstantlyImpossible extends RuntimeException
{
    public static function fromReason(Throwable $reason): self
    {
        return new self(
            'Conversion between ' . SerializableObject::class . ' and ' . ProcessableMessage::class . ' will not be possible.' . PHP_EOL . "Reason: {$reason->getMessage()}",
            $reason->getCode(),
            $reason
        );
    }

    private function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}