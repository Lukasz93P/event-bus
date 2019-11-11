<?php


namespace Lukasz93P\eventBus;


use Doctrine\Common\Collections\Collection;

interface EventsRecorder
{
    /**
     * @return Collection|DomainEvent[]
     */
    public function recordedEvents(): Collection;

    public function clearRecordedEvents(): void;
}