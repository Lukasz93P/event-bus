<?php
declare(strict_types=1);


namespace Lukasz93P\EventBus\exceptions;


class EventConstantlyUnprocessable extends EventBusException
{
    protected static function message(): string
    {
        return "Event was marked as constantly unprocessable and will not be delivered again.";
    }

}