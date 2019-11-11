<?php


namespace Lukasz93P\eventBus\serializableMessageConverter;


use Lukasz93P\AsyncMessageChannel\Message;
use Lukasz93P\eventBus\serializableMessageConverter\exceptions\ConversionFailed;
use Lukasz93P\objectSerializer\SerializableObject;

interface SerializableMessageConverter
{
    /**
     * @param SerializableObject $serializableObject
     * @return Message
     * @throws ConversionFailed
     */
    public function toMessage(SerializableObject $serializableObject): Message;

    /**
     * @param SerializableObject[] $serializableObjects
     * @return Message[]
     * @throws ConversionFailed
     */
    public function toMessages(array $serializableObjects): array;

    /**
     * @param Message $message
     * @return SerializableObject
     * @throws ConversionFailed
     */
    public function toObject(Message $message): SerializableObject;


    /**
     * @param array $messages
     * @return array
     * @throws ConversionFailed
     */
    public function toObjects(array $messages): array;
}