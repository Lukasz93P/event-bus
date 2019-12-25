<?php


namespace Lukasz93P\EventBus\event;


abstract class BasePublishableAndProcessableEvent extends PublishableEvent
{
    use ProcessableEventTrait;
}