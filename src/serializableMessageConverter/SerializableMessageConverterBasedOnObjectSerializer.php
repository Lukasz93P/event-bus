<?php


namespace Lukasz93P\eventBus\serializableMessageConverter;


use Lukasz93P\AsyncMessageChannel\BasicMessage;
use Lukasz93P\AsyncMessageChannel\Message;
use Lukasz93P\eventBus\serializableMessageConverter\exceptions\ConversionFailed;
use Lukasz93P\objectSerializer\exceptions\DeserializationFailed;
use Lukasz93P\objectSerializer\ObjectSerializer;
use Lukasz93P\objectSerializer\SerializableObject;

class SerializableMessageConverterBasedOnObjectSerializer implements SerializableMessageConverter
{
    /**
     * @var ObjectSerializer
     */
    private $objectSerializer;

    public static function withObjectSerializer(ObjectSerializer $serializer): SerializableMessageConverter
    {
        return new self($serializer);
    }

    private function __construct(ObjectSerializer $objectSerializer)
    {
        $this->objectSerializer = $objectSerializer;
    }

    public function toMessage(SerializableObject $serializableObject): Message
    {
        try {
            return BasicMessage::fromIdAndBody($serializableObject->id(), $this->objectSerializer->serialize($serializableObject));
        } catch (DeserializationFailed $deserializationFailed) {
            throw ConversionFailed::fromReason($deserializationFailed);
        }
    }

    public function toMessages(array $serializableObjects): array
    {
        return array_map(
            function (SerializableObject $serializableObject) {
                return $this->toMessage($serializableObject);
            },
            $serializableObjects
        );
    }

    public function toObject(Message $message): SerializableObject
    {
        try {
            return $this->objectSerializer->deserialize($message->body());
        } catch (DeserializationFailed $deserializationFailed) {
            throw ConversionFailed::fromReason($deserializationFailed);
        }
    }

    public function toObjects(array $messages): array
    {
        return array_map(
            function (Message $message) {
                return $this->toObject($message);
            },
            $messages
        );
    }

}