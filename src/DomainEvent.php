<?php

declare(strict_types=1);

namespace Papyrus\EventSourcing;

interface DomainEvent
{
    public function getEventName(): string;

    public function getAggregateRootId(): string;
}
