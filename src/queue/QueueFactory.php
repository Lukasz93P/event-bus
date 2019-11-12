<?php


namespace Lukasz93P\tasksQueue\queue;


use Lukasz93P\AsyncMessageChannel\AsynchronousMessageChannel;
use Lukasz93P\objectSerializer\ObjectSerializer;
use Lukasz93P\tasksQueue\serializableMessageConverter\SerializableMessageConverterBasedOnObjectSerializer;

final class QueueFactory
{
    public static function synchronous(): Queue
    {
        return new JustForwardingQueue();
    }

    public static function asynchronous(
        AsynchronousMessageChannel $asynchronousMessageChannel,
        ObjectSerializer $serializer
    ): AsynchronousQueue {
        return AsynchronousMessageQueue::fromAsynchronousMessageChannelAndSerializableMessageConverter(
            $asynchronousMessageChannel,
            SerializableMessageConverterBasedOnObjectSerializer::withObjectSerializer($serializer)
        );
    }

}