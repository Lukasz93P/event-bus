<?php
declare(strict_types=1);


namespace Lukasz93P\EventBus;


use Lukasz93P\EventBus\exceptions\EventsPublicationFailed;
use Lukasz93P\EventBus\handler\EventHandler;
use Lukasz93P\EventBus\handler\EventHandlerToAsynchronousTasksHandlerAdapter;
use Lukasz93P\tasksQueue\queue\AsynchronousQueue;
use Lukasz93P\tasksQueue\queue\exceptions\EnqueuingFailed;

class EventBusBuiltOnAsynchronousTasksQueue implements EventBus
{
    /**
     * @var AsynchronousQueue
     */
    private $decoratedAsynchronousTasksQueue;

    public function __construct(AsynchronousQueue $decoratedAsynchronousTasksQueue)
    {
        $this->decoratedAsynchronousTasksQueue = $decoratedAsynchronousTasksQueue;
    }

    public function register(EventHandler $eventHandler, string $eventClassName): EventBus
    {
        $this->decoratedAsynchronousTasksQueue->register(EventHandlerToAsynchronousTasksHandlerAdapter::adapterFor($eventHandler), $eventClassName);

        return $this;
    }

    public function publish(array $events): void
    {
        try {
            $this->decoratedAsynchronousTasksQueue->enqueue($events);
        } catch (EnqueuingFailed $exception) {
            throw EventsPublicationFailed::fromReason($exception);
        }
    }

    public function startProcessingEvents(string $eventsQueueName): void
    {
        $this->decoratedAsynchronousTasksQueue->startTasksProcessingLoop($eventsQueueName);
    }

}