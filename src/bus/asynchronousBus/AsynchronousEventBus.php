<?php


namespace Lukasz93P\eventBus\bus\asynchronousBus;


use ErrorException;
use Lukasz93P\eventBus\bus\EventBus;
use Lukasz93P\eventBus\exceptions\ObjectInsideEventsQueueIsNotAnEvent;

interface AsynchronousEventBus extends EventBus
{
    /**
     * @param string $queueName
     * @throws ErrorException
     * @throws ObjectInsideEventsQueueIsNotAnEvent
     */
    public function startEventsProcessingLoop(string $queueName): void;
}