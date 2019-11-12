<?php


namespace Lukasz93P\tasksQueue;


use Lukasz93P\objectSerializer\SerializableObject;

interface AsynchronousTask extends SerializableObject
{
    public function queueKey(): string;

    public function createdAt(): string;
}