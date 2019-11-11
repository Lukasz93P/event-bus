<?php


namespace Lukasz93P\eventBus\bus;


use Doctrine\Common\Collections\Collection;
use Lukasz93P\eventBus\DomainEvent;
use Lukasz93P\eventBus\EventHandler;
use Lukasz93P\eventBus\exceptions\EventsPublicationFailed;

interface EventBus
{
    public function register(EventHandler $eventHandler, string $eventClassName): EventBus;

    /**
     * @param Collection|DomainEvent[] $events
     * @throws EventsPublicationFailed
     */
    public function publish(Collection $events): void;
}