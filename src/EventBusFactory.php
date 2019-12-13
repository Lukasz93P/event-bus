<?php
declare(strict_types=1);


namespace Lukasz93P\EventBus;


use Lukasz93P\tasksQueue\queue\QueueFactory;
use Psr\Log\LoggerInterface;

class EventBusFactory
{
    public static function withLogger(LoggerInterface $logger, array $eventsIdentificationKeysToClassNamesMapping): EventBus
    {
        return new EventBusBuiltOnAsynchronousTasksQueue(QueueFactory::asynchronous($logger, $eventsIdentificationKeysToClassNamesMapping));
    }

}