<?php
declare(strict_types=1);


namespace Lukasz93P\EventBus\eventRecorder;


use Lukasz93P\EventBus\event\PublishableEvent;

interface EventRecorder
{
    /**
     * @return PublishableEvent[]
     */
    public function recordedEvents(): array;

    public function clearEvents(): void;
}