<?php
declare(strict_types=1);


namespace Lukasz93P\EventBus\exceptions;


use Lukasz93P\EventBus\event\ProcessableEvent;
use RuntimeException;

class EnqueuedObjectIsNotAnEvent extends RuntimeException
{
    /**
     * @var object
     */
    private $object;

    public static function fromObject($enqueuedObject): self
    {
        return new self($enqueuedObject);
    }

    private function __construct($object)
    {
        parent::__construct('Enqueued object is not an ' . ProcessableEvent::class);
        $this->object = $object;
    }

    public function object()
    {
        return $this->object;
    }

}