<?php


namespace Lukasz93P\eventBus;


use Lukasz93P\objectSerializer\SerializableObject;

interface DomainEvent extends SerializableObject
{
    public function id(): string;

    public function aggregateId(): string;

    public function occurredAt(): string;
}