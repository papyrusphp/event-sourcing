<?php

declare(strict_types=1);

namespace Papyrus\EventSourcing;

trait EventSourceableAggregateRootTrait
{
    private int $playhead = 0;

    /** @var list<DomainEvent> */
    private array $appliedEvents = [];

    protected function __construct()
    {
        // Prevent direct aggregate root construct, make use of named constructors instead
    }

    public static function reconstituteFromEvents(DomainEvent ...$events): self
    {
        $aggregateRoot = new self();
        $aggregateRoot->handleEvent(...$events);

        return $aggregateRoot;
    }

    public function getPlayhead(): int
    {
        return $this->playhead;
    }

    public function getAppliedEvents(): array
    {
        return $this->appliedEvents;
    }

    public function clearAppliedEvents(): void
    {
        $this->appliedEvents = [];
    }

    protected function apply(DomainEvent $event): void
    {
        $this->handleEvent($event);
        $this->appliedEvents[] = $event;
    }

    private function handleEvent(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            ++$this->playhead;

            $method = $this->getHandleMethod($event);

            if (method_exists($this, $method) === false) {
                return;
            }

            $this->{$method}($event);
        }
    }

    private function getHandleMethod(DomainEvent $event): string
    {
        $classParts = explode('\\', $event::class);

        return sprintf('apply%s', end($classParts));
    }
}
