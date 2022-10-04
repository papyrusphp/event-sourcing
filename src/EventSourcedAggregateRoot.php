<?php

declare(strict_types=1);

namespace Papyrus\EventSourcing;

interface EventSourcedAggregateRoot extends AggregateRoot
{
    public static function reconstituteFromEvents(DomainEvent ...$events): self;

    public function getPlayhead(): int;

    /**
     * @return list<DomainEvent>
     */
    public function getAppliedEvents(): array;

    public function clearAppliedEvents(): void;
}
