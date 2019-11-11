<?php


namespace Lukasz93P\eventBus\exceptions;


use Lukasz93P\eventBus\DomainEvent;
use RuntimeException;
use Throwable;

class ObjectInsideEventsQueueIsNotAnEvent extends RuntimeException
{
    /**
     * @var object
     */
    private $object;

    public static function fromObject($object): self
    {
        return new self($object, "Serialized object from event queue is not instance of " . DomainEvent::class);
    }

    /**
     * ObjectInsideEventsQueueIsNotAnEvent constructor.
     * @param object $object
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    private function __construct($object, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->object = $object;
    }

    public function object()
    {
        return $this->object;
    }

}