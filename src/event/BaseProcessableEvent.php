<?php
declare(strict_types=1);


namespace Lukasz93P\EventBus\event;


class BaseProcessableEvent extends Event implements ProcessableEvent
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

}