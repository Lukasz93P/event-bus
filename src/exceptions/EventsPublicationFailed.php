<?php
declare(strict_types=1);


namespace Lukasz93P\EventBus\exceptions;


class EventsPublicationFailed extends EventBusException
{
    protected static function generateBaseMessage(): string
    {
        return "Events publication failed.";
    }

}