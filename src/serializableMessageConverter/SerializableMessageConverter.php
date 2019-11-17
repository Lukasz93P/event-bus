<?php
declare(strict_types=1);


namespace Lukasz93P\tasksQueue\serializableMessageConverter;


use Lukasz93P\AsyncMessageChannel\ProcessableMessage;
use Lukasz93P\AsyncMessageChannel\PublishableMessage;
use Lukasz93P\objectSerializer\SerializableObject;
use Lukasz93P\tasksQueue\PublishableAsynchronousTask;
use Lukasz93P\tasksQueue\serializableMessageConverter\exceptions\ConversionConstantlyImpossible;
use Lukasz93P\tasksQueue\serializableMessageConverter\exceptions\ConversionFailed;

interface SerializableMessageConverter
{
    public function toMessage(PublishableAsynchronousTask $asynchronousTask): PublishableMessage;

    /**
     * @param PublishableAsynchronousTask[] $asynchronousTasks
     * @return PublishableMessage[]
     */
    public function toMessages(array $asynchronousTasks): array;

    /**
     * @param ProcessableMessage $message
     * @return SerializableObject
     * @throws ConversionFailed
     * @throws ConversionConstantlyImpossible
     */
    public function toObject(ProcessableMessage $message): SerializableObject;
}