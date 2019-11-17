<?php
declare(strict_types=1);


namespace Lukasz93P\EventBus\handler;


use Lukasz93P\EventBus\event\ProcessableEvent;
use Lukasz93P\EventBus\exceptions\EventConstantlyUnprocessable;

interface EventHandler
{
    /**
     * @param ProcessableEvent $event
     * @throws EventConstantlyUnprocessable
     */
    public function handle(ProcessableEvent $event): void;
}