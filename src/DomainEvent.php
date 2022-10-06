<?php

declare(strict_types=1);

namespace Papyrus\EventSourcing;

interface DomainEvent
{
    public static function getEventName(): string;

    public function getAggregateRootId(): string;
}
