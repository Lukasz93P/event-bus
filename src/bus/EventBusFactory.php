<?php


namespace Lukasz93P\eventBus\bus;


use Lukasz93P\AsyncMessageChannel\AsynchronousMessageChannel;
use Lukasz93P\eventBus\bus\asynchronousBus\AsynchronousEventBus;
use Lukasz93P\eventBus\bus\asynchronousBus\AsynchronousMessagesEventBus;
use Lukasz93P\eventBus\serializableMessageConverter\SerializableMessageConverter;

final class EventBusFactory
{
    public static function synchronous(): EventBus
    {
        return new JustForwardingEventBus();
    }

    public static function asynchronous(
        AsynchronousMessageChannel $asynchronousMessageChannel,
        SerializableMessageConverter $serializableMessageConverter
    ): AsynchronousEventBus {
        return new AsynchronousMessagesEventBus($asynchronousMessageChannel, $serializableMessageConverter);
    }

}