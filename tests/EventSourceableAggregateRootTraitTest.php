<?php

declare(strict_types=1);

namespace Papyrus\EventSourcing\Test;

use Papyrus\EventSourcing\Test\Stub\AnotherTestDomainEvent;
use Papyrus\EventSourcing\Test\Stub\TestAggregateRoot;
use Papyrus\EventSourcing\Test\Stub\TestDomainEvent;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class EventSourceableAggregateRootTraitTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldApplyEvents(): void
    {
        $aggregateRoot = TestAggregateRoot::create();

        self::assertCount(0, $aggregateRoot->getAppliedEvents());

        $aggregateRoot->testApplyEvent($eventA = new TestDomainEvent());
        $aggregateRoot->testApplyEvent($eventB = new TestDomainEvent());

        self::assertSame([$eventA, $eventB], $aggregateRoot->getAppliedEvents());

        $aggregateRoot->testApplyEvent($eventC = new TestDomainEvent());

        self::assertSame([$eventA, $eventB, $eventC], $aggregateRoot->getAppliedEvents());
    }

    /**
     * @test
     */
    public function itShouldClearAppliedEvents(): void
    {
        $aggregateRoot = TestAggregateRoot::create();
        $aggregateRoot->testApplyEvent($eventA = new TestDomainEvent());
        $aggregateRoot->testApplyEvent($eventB = new TestDomainEvent());

        self::assertSame([$eventA, $eventB], $aggregateRoot->getAppliedEvents());

        $aggregateRoot->clearAppliedEvents();

        self::assertCount(0, $aggregateRoot->getAppliedEvents());
    }

    /**
     * @test
     */
    public function itShouldKeepTrackOfPlayhead(): void
    {
        $aggregateRoot = TestAggregateRoot::create();

        self::assertSame(0, $aggregateRoot->getPlayhead());

        $aggregateRoot->testApplyEvent(new TestDomainEvent());

        self::assertSame(1, $aggregateRoot->getPlayhead());

        $aggregateRoot->testApplyEvent(new TestDomainEvent());

        self::assertSame(2, $aggregateRoot->getPlayhead());
    }

    /**
     * @test
     */
    public function itShouldHandleApplyMethod(): void
    {
        $aggregateRoot = TestAggregateRoot::create();

        self::assertCount(0, $aggregateRoot->applied);

        $aggregateRoot->testApplyEvent($event = new TestDomainEvent());

        self::assertSame([$event], $aggregateRoot->applied);
    }

    /**
     * @test
     */
    public function itShouldNotHandleApplyMethodIfNotAvailable(): void
    {
        $aggregateRoot = TestAggregateRoot::create();

        self::assertCount(0, $aggregateRoot->applied);

        $aggregateRoot->testApplyEvent($event = new AnotherTestDomainEvent());

        self::assertCount(0, $aggregateRoot->applied);
    }

    /**
     * @test
     */
    public function itShouldReconstituteFromEvents(): void
    {
        $aggregateRoot = TestAggregateRoot::reconstituteFromEvents(
            $eventA = new TestDomainEvent(),
            new AnotherTestDomainEvent(),
        );

        self::assertSame(2, $aggregateRoot->getPlayhead());
        self::assertSame([$eventA], $aggregateRoot->applied);
        self::assertCount(0, $aggregateRoot->getAppliedEvents());
    }
}
