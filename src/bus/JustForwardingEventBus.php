<?php


namespace Lukasz93P\eventBus\bus;


use Doctrine\Common\Collections\Collection;
use Lukasz93P\eventBus\DomainEvent;
use Lukasz93P\eventBus\exceptions\EventsPublicationFailed;
use Throwable;

class JustForwardingEventBus extends BaseEventBus implements EventBus
{
    public function publish(Collection $events): void
    {
        foreach ($events as $event) {
            $this->handleEvent($event);
        }
    }

    private function handleEvent(DomainEvent $event): void
    {
        $handler = $this->findHandlerFor($event);
        if (!$handler) {
            return;
        }
        try {
            $handler->handle($event);
        } catch (Throwable $throwable) {
            throw EventsPublicationFailed::fromReason($throwable);
        }
    }

}