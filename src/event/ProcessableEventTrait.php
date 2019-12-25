<?php
declare(strict_types=1);


namespace Lukasz93P\EventBus\event;


trait ProcessableEventTrait
{
    public function id(): string
    {
        return $this->getId();
    }

    public function aggregateId(): string
    {
        return $this->getAggregateId();
    }

    public function occurredAt(): string
    {
        return $this->getOccurredAt();
    }

    abstract protected function getId(): string;

    abstract protected function getAggregateId(): string;

    abstract protected function getOccurredAt(): string;
}