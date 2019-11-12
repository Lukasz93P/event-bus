<?php


namespace Lukasz93P\tasksQueue;


interface TaskHandler
{
    public function handle(AsynchronousTask $task): void;
}