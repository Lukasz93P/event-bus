<?php
declare(strict_types=1);


namespace Lukasz93P\EventBus\event;


abstract class BaseProcessableEvent extends Event implements ProcessableEvent
{
    use ProcessableEventTrait;
}