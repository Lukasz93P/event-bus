<?php
declare(strict_types=1);


namespace Lukasz93P\EventBus;


use Lukasz93P\EventBus\event\PublishableEvent;
use Lukasz93P\EventBus\exceptions\EventsPublicationFailed;
use Lukasz93P\EventBus\handler\EventHandler;
use Throwable;

interface EventBus
{
    public function register(EventHandler $eventHandler, string $eventClassName): EventBus;

    /**
     * @param PublishableEvent[] $events
     * @throws EventsPublicationFailed
     */
    public function publish(array $events): void;

    /**
     * @param string $eventsQueueName
     * @throws Throwable
     */
    public function startProcessingEvents(string $eventsQueueName): void;
}