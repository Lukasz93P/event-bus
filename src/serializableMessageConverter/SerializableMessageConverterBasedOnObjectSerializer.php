<?php
declare(strict_types=1);


namespace Lukasz93P\tasksQueue\serializableMessageConverter;


use Lukasz93P\AsyncMessageChannel\BasicMessage;
use Lukasz93P\AsyncMessageChannel\ProcessableMessage;
use Lukasz93P\AsyncMessageChannel\PublishableMessage;
use Lukasz93P\objectSerializer\exceptions\DeserializationFailed;
use Lukasz93P\objectSerializer\ObjectSerializer;
use Lukasz93P\objectSerializer\SerializableObject;
use Lukasz93P\tasksQueue\PublishableAsynchronousTask;
use Lukasz93P\tasksQueue\serializableMessageConverter\exceptions\ConversionFailed;

class SerializableMessageConverterBasedOnObjectSerializer implements SerializableMessageConverter
{
    /**
     * @var ObjectSerializer
     */
    private $objectSerializer;

    public static function withObjectSerializer(ObjectSerializer $objectSerializer): SerializableMessageConverter
    {
        return new self($objectSerializer);
    }

    private function __construct(ObjectSerializer $objectSerializer)
    {
        $this->objectSerializer = $objectSerializer;
    }

    public function toMessage(PublishableAsynchronousTask $asynchronousTask): PublishableMessage
    {
        return BasicMessage::publishable(
            $asynchronousTask->routingKey(),
            $asynchronousTask->exchange(),
            $this->objectSerializer->serialize($asynchronousTask)
        );
    }

    public function toMessages(array $asynchronousTasks): array
    {
        return array_map(
            function (PublishableAsynchronousTask $asynchronousTask) {
                return $this->toMessage($asynchronousTask);
            },
            $asynchronousTasks
        );
    }

    public function toObject(ProcessableMessage $message): SerializableObject
    {
        try {
            return $this->objectSerializer->deserialize($message->body());
        } catch (DeserializationFailed $deserializationFailed) {
            throw ConversionFailed::fromReason($deserializationFailed);
        }
    }

}