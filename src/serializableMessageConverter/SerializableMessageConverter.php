<?php
declare(strict_types=1);


namespace Lukasz93P\tasksQueue\serializableMessageConverter;


use Lukasz93P\AsyncMessageChannel\ProcessableMessage;
use Lukasz93P\AsyncMessageChannel\PublishableMessage;
use Lukasz93P\objectSerializer\SerializableObject;
use Lukasz93P\tasksQueue\AsynchronousTask;
use Lukasz93P\tasksQueue\serializableMessageConverter\exceptions\ConversionFailed;

interface SerializableMessageConverter
{
    public function toMessage(AsynchronousTask $asynchronousTask): PublishableMessage;

    /**
     * @param AsynchronousTask[] $asynchronousTasks
     * @return PublishableMessage[]
     */
    public function toMessages(array $asynchronousTasks): array;

    /**
     * @param ProcessableMessage $message
     * @return SerializableObject
     * @throws ConversionFailed
     */
    public function toObject(ProcessableMessage $message): SerializableObject;
}