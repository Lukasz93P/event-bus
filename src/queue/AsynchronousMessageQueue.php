<?php


namespace Lukasz93P\tasksQueue\queue;


use Doctrine\Common\Collections\Collection;
use Lukasz93P\AsyncMessageChannel\AsynchronousMessageChannel;
use Lukasz93P\AsyncMessageChannel\exceptions\MessageConstantlyUnprocessable;
use Lukasz93P\AsyncMessageChannel\exceptions\MessagePublishingFailed;
use Lukasz93P\AsyncMessageChannel\MessageHandler;
use Lukasz93P\AsyncMessageChannel\ProcessableMessage;
use Lukasz93P\tasksQueue\AsynchronousTask;
use Lukasz93P\tasksQueue\queue\exceptions\EnqueuingFailed;
use Lukasz93P\tasksQueue\queue\exceptions\ObjectInsideTasksQueueIsNotAnAsynchronousTask;
use Lukasz93P\tasksQueue\serializableMessageConverter\exceptions\ConversionFailed;
use Lukasz93P\tasksQueue\serializableMessageConverter\SerializableMessageConverter;

class AsynchronousMessageQueue extends BaseQueue implements AsynchronousQueue, MessageHandler
{
    /**
     * @var AsynchronousMessageChannel
     */
    private $asynchronousMessageChannel;

    /**
     * @var SerializableMessageConverter
     */
    private $serializableMessageConverter;

    public static function fromAsynchronousMessageChannelAndSerializableMessageConverter(
        AsynchronousMessageChannel $asynchronousMessageChannel,
        SerializableMessageConverter $serializableMessageConverter
    ): AsynchronousQueue {
        return new self($asynchronousMessageChannel, $serializableMessageConverter);
    }

    private function __construct(AsynchronousMessageChannel $asynchronousMessageChannel, SerializableMessageConverter $serializableMessageConverter)
    {
        $this->asynchronousMessageChannel = $asynchronousMessageChannel;
        $this->serializableMessageConverter = $serializableMessageConverter;
    }

    /**
     * @param Collection|AsynchronousTask[] $tasks
     */
    public function enqueue(Collection $tasks): void
    {
        try {
            $this->asynchronousMessageChannel->add($this->serializableMessageConverter->toMessages($tasks->toArray()));
        } catch (MessagePublishingFailed | ConversionFailed $exception) {
            throw EnqueuingFailed::fromReason($exception);
        }
    }

    public function startTasksProcessingLoop(string $queueKey): void
    {
        $this->asynchronousMessageChannel->startProcessingQueue($this, $queueKey);
    }

    public function handle(ProcessableMessage $message): void
    {
        try {
            $task = $this->serializableMessageConverter->toObject($message);
            $this->checkIfEnqueuedObjectIsAsynchronousTaskEvent($task);
        } catch (ObjectInsideTasksQueueIsNotAnAsynchronousTask | ConversionFailed $exception) {
            throw MessageConstantlyUnprocessable::fromReason($exception);
        }
        /** @var AsynchronousTask $task */
        $this->handleTask($task);
    }

    private function checkIfEnqueuedObjectIsAsynchronousTaskEvent($enqueuedObject): void
    {
        if (!$enqueuedObject instanceof AsynchronousTask) {
            throw ObjectInsideTasksQueueIsNotAnAsynchronousTask::fromObject($enqueuedObject);
        }
    }

    private function handleTask(AsynchronousTask $task): void
    {
        $handler = $this->findHandlerFor($task);
        if (!$handler) {
            return;
        }
        $handler->handle($task);
    }

}