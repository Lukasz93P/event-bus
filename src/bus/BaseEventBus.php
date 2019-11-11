<?php


namespace Lukasz93P\eventBus\bus;


use Lukasz93P\eventBus\DomainEvent;
use Lukasz93P\eventBus\EventHandler;

abstract class BaseEventBus implements EventBus
{
    /**
     * @var EventHandler[]
     */
    private $registeredHandlers = [];

    public function register(EventHandler $eventHandler, string $eventClassName): EventBus
    {
        $this->registeredHandlers[$eventClassName] = $eventHandler;

        return $this;
    }

    protected function findHandlerFor(DomainEvent $event): ?EventHandler
    {
        return $this->registeredHandlers[get_class($event)] ?? null;
    }

}