<?php

declare(strict_types=1);

namespace Papyrus\EventSourcing;

interface NamedDomainEvent
{
    public static function getEventName(): string;
}
