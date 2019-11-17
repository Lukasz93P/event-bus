<?php
declare(strict_types=1);


namespace Lukasz93P\EventBus\exceptions;


class EventsPublicationFailed extends EventBusException
{
    protected static function message(): string
    {
        return "Events publication failed.";
    }

}