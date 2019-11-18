<?php
declare(strict_types=1);


namespace Lukasz93P\EventBus\eventRecorder;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Lukasz93P\EventBus\event\PublishableEvent;

abstract class BaseEventRecorder implements EventRecorder
{
    /**
     * @var Collection|PublishableEvent[]
     */
    private $recordedEvents;

    protected function __construct()
    {
        $this->recordedEvents = new ArrayCollection();
    }

    public function recordedEvents(): array
    {
        return $this->recordedEvents->toArray();
    }

    public function clearEvents(): void
    {
        $this->recordedEvents->clear();
    }

    protected function raise(PublishableEvent $event): void
    {
        if ($this->recordedEvents->contains($event)) {
            return;
        }
        $this->recordedEvents->add($event);
    }

}