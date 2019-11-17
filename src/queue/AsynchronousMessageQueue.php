<?php
declare(strict_types=1);


namespace Lukasz93P\tasksQueue\queue;


use Lukasz93P\AsyncMessageChannel\AsynchronousMessageChannel;
use Lukasz93P\AsyncMessageChannel\exceptions\MessageConstantlyUnprocessable;
use Lukasz93P\AsyncMessageChannel\exceptions\MessagePublishingFailed;
use Lukasz93P\AsyncMessageChannel\MessageHandler;
use Lukasz93P\AsyncMessageChannel\ProcessableMessage;
use Lukasz93P\tasksQueue\ProcessableAsynchronousTask;
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

    public function __construct(AsynchronousMessageChannel $asynchronousMessageChannel, SerializableMessageConverter $serializableMessageConverter)
    {
        $this->asynchronousMessageChannel = $asynchronousMessageChannel;
        $this->serializableMessageConverter = $serializableMessageConverter;
    }

    public function enqueue(array $tasks): void
    {
        try {
            $this->asynchronousMessageChannel->add($this->serializableMessageConverter->toMessages($tasks));
        } catch (MessagePublishingFailed $exception) {
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
            $this->checkIfEnqueuedObjectIsProcessableAsynchronousTask($task);
        } catch (ObjectInsideTasksQueueIsNotAnAsynchronousTask | ConversionFailed $exception) {
            throw MessageConstantlyUnprocessable::fromReason($exception);
        }
        /** @var ProcessableAsynchronousTask $task */
        $this->handleTask($task);
    }

    private function checkIfEnqueuedObjectIsProcessableAsynchronousTask($enqueuedObject): void
    {
        if (!$enqueuedObject instanceof ProcessableAsynchronousTask) {
            throw ObjectInsideTasksQueueIsNotAnAsynchronousTask::fromObject($enqueuedObject);
        }
    }

}