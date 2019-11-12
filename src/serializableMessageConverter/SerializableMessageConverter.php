<?php


namespace Lukasz93P\tasksQueue\serializableMessageConverter;


use Lukasz93P\AsyncMessageChannel\ProcessableMessage;
use Lukasz93P\AsyncMessageChannel\PublishableMessage;
use Lukasz93P\objectSerializer\SerializableObject;
use Lukasz93P\tasksQueue\serializableMessageConverter\exceptions\ConversionFailed;

interface SerializableMessageConverter
{
    /**
     * @param SerializableObject $serializableObject
     * @return PublishableMessage
     * @throws ConversionFailed
     */
    public function toMessage(SerializableObject $serializableObject): PublishableMessage;

    /**
     * @param SerializableObject[] $serializableObjects
     * @return PublishableMessage[]
     * @throws ConversionFailed
     */
    public function toMessages(array $serializableObjects): array;

    /**
     * @param ProcessableMessage $message
     * @return SerializableObject
     * @throws ConversionFailed
     */
    public function toObject(ProcessableMessage $message): SerializableObject;


    /**
     * @param ProcessableMessage[] $messages
     * @return array
     * @throws ConversionFailed
     */
    public function toObjects(array $messages): array;
}