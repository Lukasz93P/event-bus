<?php


namespace Lukasz93P\eventBus;


interface EventHandler
{
    public function handle(DomainEvent $domainEvent): void;
}