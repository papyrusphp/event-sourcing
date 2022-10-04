<?php

declare(strict_types=1);

namespace Papyrus\EventSourcing\Test\Stub;

use Papyrus\EventSourcing\DomainEvent;

final class AnotherTestDomainEvent implements DomainEvent
{
    public function getEventName(): string
    {
        return 'test.another_domain_event';
    }

    public function getAggregateRootId(): string
    {
        return '9549c4f7-8986-43ad-aa56-c038e556c90c';
    }
}
