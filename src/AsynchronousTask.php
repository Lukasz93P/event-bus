<?php
declare(strict_types=1);


namespace Lukasz93P\tasksQueue;


use Lukasz93P\objectSerializer\SerializableObject;

interface AsynchronousTask extends SerializableObject
{
    public function routingKey(): string;

    public function exchange(): string;
}