<?php


namespace Lukasz93P\tasksQueue;


use Carbon\Carbon;
use JMS\Serializer\Annotation as Serializer;

abstract class BaseAsynchronousTask implements AsynchronousTask
{
    private $queueKey;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\SerializedName("createdAt")
     */
    private $createdAt;

    protected function __construct(string $queueKey, string $createdAt)
    {
        $this->queueKey = $queueKey;
        $this->createdAt = Carbon::parse($createdAt)->toDateTimeString();
    }

    public function queueKey(): string
    {
        return $this->queueKey;
    }

    public function createdAt(): string
    {
        return $this->createdAt;
    }

}