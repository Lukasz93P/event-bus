<?php
declare(strict_types=1);


namespace Lukasz93P\EventBus\event;


use Lukasz93P\tasksQueue\ProcessableAsynchronousTask;

interface ProcessableEvent extends ProcessableAsynchronousTask
{
    public function id(): string;

    public function aggregateId(): string;

    public function occurredAt(): string;
}