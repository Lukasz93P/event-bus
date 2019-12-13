<?php
declare(strict_types=1);


namespace Lukasz93P\EventBus\event;


use Assert\Assertion;
use Assert\AssertionFailedException;
use InvalidArgumentException;
use Lukasz93P\tasksQueue\PublishableAsynchronousTask;

abstract class PublishableEvent extends Event implements PublishableAsynchronousTask
{
    /**
     * @var string
     */
    private $routingKey;

    /**
     * @var string
     */
    private $exchange;

    /**
     * @var string
     */
    private $classIdentificationKey;

    protected function __construct(EventId $id, string $aggregateId, string $routingKey, string $exchange, string $classIdentificationKey)
    {
        parent::__construct($id, $aggregateId);
        $this->setRoutingKey($routingKey)
            ->setExchange($exchange)
            ->setClassIdentificationKey($classIdentificationKey);
    }

    private function setRoutingKey(string $routingKey): self
    {
        try {
            Assertion::notBlank($routingKey);
        } catch (AssertionFailedException $exception) {
            throw new InvalidArgumentException();
        }
        $this->routingKey = $routingKey;

        return $this;
    }

    private function setExchange(string $exchange): self
    {
        try {
            Assertion::notBlank($exchange);
        } catch (AssertionFailedException $exception) {
            throw new InvalidArgumentException();
        }
        $this->exchange = $exchange;

        return $this;
    }

    private function setClassIdentificationKey(string $classIdentificationKey): self
    {
        try {
            Assertion::notBlank($classIdentificationKey);
        } catch (AssertionFailedException $exception) {
            throw new InvalidArgumentException();
        }
        $this->classIdentificationKey = $classIdentificationKey;

        return $this;
    }

    public function routingKey(): string
    {
        return $this->routingKey;
    }

    public function exchange(): string
    {
        return $this->exchange;
    }

    public function classIdentificationKey(): string
    {
        return $this->classIdentificationKey;
    }

}