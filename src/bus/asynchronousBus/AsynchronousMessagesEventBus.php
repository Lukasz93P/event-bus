<?php


namespace Lukasz93P\eventBus\bus\asynchronousBus;


use Doctrine\Common\Collections\Collection;
use Lukasz93P\AsyncMessageChannel\AsynchronousMessageChannel;
use Lukasz93P\AsyncMessageChannel\exceptions\MessagePublishingFailed;
use Lukasz93P\AsyncMessageChannel\Message;
use Lukasz93P\AsyncMessageChannel\MessageHandler;
use Lukasz93P\eventBus\bus\BaseEventBus;
use Lukasz93P\eventBus\DomainEvent;
use Lukasz93P\eventBus\exceptions\EventsPublicationFailed;
use Lukasz93P\eventBus\exceptions\ObjectInsideEventsQueueIsNotAnEvent;
use Lukasz93P\eventBus\serializableMessageConverter\exceptions\ConversionFailed;
use Lukasz93P\eventBus\serializableMessageConverter\SerializableMessageConverter;

class AsynchronousMessagesEventBus extends BaseEventBus implements AsynchronousEventBus, MessageHandler
{
    /**
     * @var AsynchronousMessageChannel
     */
    private $asynchronousMessageChannel;

    /**
     * @var SerializableMessageConverter
     */
    private $serializableMessageConverter;

    public function __construct(AsynchronousMessageChannel $asynchronousMessageChannel, SerializableMessageConverter $serializableMessageConverter)
    {
        $this->asynchronousMessageChannel = $asynchronousMessageChannel;
        $this->serializableMessageConverter = $serializableMessageConverter;
    }

    /**
     * @param Collection|DomainEvent[] $events
     */
    public function publish(Collection $events): void
    {
        try {
            $this->asynchronousMessageChannel->add($this->serializableMessageConverter->toMessages($events->toArray()));
        } catch (MessagePublishingFailed | ConversionFailed $exception) {
            throw EventsPublicationFailed::fromReason($exception);
        }
    }

    public function startEventsProcessingLoop(string $queueName): void
    {
        $this->asynchronousMessageChannel->startProcessingQueue($this, $queueName);
    }

    public function handle(Message $message): void
    {
        $event = $this->serializableMessageConverter->toObject($message);
        $this->checkIfEnqueuedObjectIsDomainEvent($event);
        /** @var DomainEvent $event */
        $this->handleEvent($event);
    }

    /**
     * @param object $enqueuedObject
     * @throws ObjectInsideEventsQueueIsNotAnEvent
     */
    private function checkIfEnqueuedObjectIsDomainEvent($enqueuedObject): void
    {
        if (!$enqueuedObject instanceof DomainEvent) {
            throw ObjectInsideEventsQueueIsNotAnEvent::fromObject($enqueuedObject);
        }
    }

    private function handleEvent(DomainEvent $event): void
    {
        $handler = $this->findHandlerFor($event);
        if (!$handler) {
            return;
        }
        $handler->handle($event);
    }

}