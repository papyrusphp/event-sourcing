<?php

declare(strict_types=1);

namespace Papyrus\EventSourcing\Test\Stub;

use Papyrus\EventSourcing\AggregateRootId;
use Papyrus\EventSourcing\DomainEvent;
use Papyrus\EventSourcing\EventSourceableAggregateRootTrait;
use Papyrus\EventSourcing\EventSourcedAggregateRoot;

final class TestAggregateRoot implements EventSourcedAggregateRoot
{
    use EventSourceableAggregateRootTrait;

    /** @var list<DomainEvent> */
    public array $applied = [];

    public static function create(): self
    {
        return new self();
    }

    public function getAggregateRootId(): AggregateRootId
    {
        return new class () implements AggregateRootId {
            public function __toString(): string
            {
                return '34b52aca-47cf-4048-bcd6-6e2a5774e4e2';
            }
        };
    }

    public function testApplyEvent(DomainEvent $event): void
    {
        $this->apply($event);
    }

    protected function applyTestDomainEvent(TestDomainEvent $event): void
    {
        $this->applied[] = $event;
    }
}
