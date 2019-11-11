<?php


namespace Lukasz93P\eventBus;


use Carbon\Carbon;
use JMS\Serializer\Annotation as Serializer;

abstract class BaseDomainEvent implements DomainEvent
{
    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $id;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\SerializedName("aggregateId")
     */
    private $aggregateId;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\SerializedName("occurredAt")
     */
    private $occurredAt;

    protected function __construct(string $id, string $aggregateId, string $occurredAt)
    {
        $this->id = $id;
        $this->aggregateId = $aggregateId;
        $this->occurredAt = Carbon::parse($occurredAt)->toDateTimeString();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function occurredAt(): string
    {
        return $this->occurredAt;
    }

}