<?php
declare(strict_types=1);


namespace Lukasz93P\EventBus\event;


use Assert\Assertion;
use Assert\AssertionFailedException;
use Carbon\Carbon;
use InvalidArgumentException;

abstract class Event
{
    /**
     * @var string
     * @Serializer\SerializedName("id")
     * @Serializer\Type("string")
     */
    private $id;

    /**
     * @var string
     * @Serializer\SerializedName("aggregateId")
     * @Serializer\Type("string")
     */
    private $aggregateId;

    /**
     * @var string
     * @Serializer\SerializedName("occurredAt")
     * @Serializer\Type("string")
     */
    private $occurredAt;

    protected function __construct(EventId $id, string $aggregateId)
    {
        $this->id = $id->toString();
        $this->setAggregateId($aggregateId);
        $this->occurredAt = Carbon::now()->toDateTimeString();
    }

    private function setAggregateId(string $aggregateId): self
    {
        try {
            Assertion::notBlank($aggregateId);
        } catch (AssertionFailedException $exception) {
            throw new InvalidArgumentException();
        }
        $this->aggregateId = $aggregateId;

        return $this;
    }

    protected function getId(): string
    {
        return $this->id;
    }

    protected function getAggregateId(): string
    {
        return $this->aggregateId;
    }

    protected function getOccurredAt(): string
    {
        return $this->occurredAt;
    }

}