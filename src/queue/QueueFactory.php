<?php
declare(strict_types=1);


namespace Lukasz93P\tasksQueue\queue;


use Lukasz93P\AsyncMessageChannel\AsynchronousMessageChannelFactory;
use Lukasz93P\objectSerializer\ObjectSerializerFactory;
use Lukasz93P\tasksQueue\serializableMessageConverter\SerializableMessageConverterBasedOnObjectSerializer;
use Psr\Log\LoggerInterface;

final class QueueFactory
{
    public static function synchronous(): Queue
    {
        return new JustForwardingQueue();
    }

    public static function asynchronous(
        LoggerInterface $logger,
        array $tasksIdentificationKeysToClassNamesMapping
    ): AsynchronousQueue {
        return new AsynchronousMessageQueue(
            AsynchronousMessageChannelFactory::withLogger($logger),
            SerializableMessageConverterBasedOnObjectSerializer::withObjectSerializer(
                ObjectSerializerFactory::create($tasksIdentificationKeysToClassNamesMapping)
            )
        );
    }

}