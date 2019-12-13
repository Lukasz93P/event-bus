<?php
declare(strict_types=1);


namespace Lukasz93P\EventBus\handler;


use Lukasz93P\EventBus\event\ProcessableEvent;
use Lukasz93P\EventBus\exceptions\EnqueuedObjectIsNotAnEvent;
use Lukasz93P\EventBus\exceptions\EventConstantlyUnprocessable;
use Lukasz93P\tasksQueue\ProcessableAsynchronousTask;
use Lukasz93P\tasksQueue\queue\exceptions\TaskConstantlyUnprocessable;
use Lukasz93P\tasksQueue\TaskHandler;

class EventHandlerToAsynchronousTasksHandlerAdapter implements TaskHandler
{
    /**
     * @var EventHandler
     */
    private $eventHandler;

    public static function adapterFor(EventHandler $eventHandler): TaskHandler
    {
        return new self($eventHandler);
    }

    private function __construct(EventHandler $eventHandler)
    {
        $this->eventHandler = $eventHandler;
    }

    public function handle(ProcessableAsynchronousTask $event): void
    {
        try {
            $this->checkIfEnqueuedObjectIsAnEvent($event);
            /** @var ProcessableEvent $event */
            $this->eventHandler->handle($event);
        } catch (EventConstantlyUnprocessable $eventConstantlyUnprocessable) {
            throw TaskConstantlyUnprocessable::fromTask($event);
        }
    }

    private function checkIfEnqueuedObjectIsAnEvent($enqueuedObject): void
    {
        if (!$enqueuedObject instanceof ProcessableEvent) {
            throw EventConstantlyUnprocessable::fromReason(EnqueuedObjectIsNotAnEvent::fromObject($enqueuedObject));
        }
    }

}