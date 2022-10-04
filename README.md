# 📜 Papyrus Event Sourcing
Yet another event sourcing library for PHP.

### Why another library?
There are already great libraries for event sourcing in PHP,
like [Broadway](https://github.com/broadway/broadway), [EventSauce](https://github.com/EventSaucePHP/EventSauce) and [Prooph](https://github.com/prooph/event-sourcing).

However, they never fitted well in projects.
After years of multiple projects using event sourcing with success,
the implementation of event sourcing evolved to what it is right now.
Influenced by the libraries above;
time to share _Papyrus_.

Questions, ideas and change requests are always welcome 🤗

### Installation
Install via composer:
```bash
$ composer install papyrus/event-sourcing
```

### How to use
This library contains a set of interfaces (the contract) for your domain layer. 
It is a basic framework for your aggregate root(s).

A **simplified** example aggregate root:
```php
use Papyrus\EventSourcing\AggregateRootId;
use Papyrus\EventSourcing\DomainEvent;
use Papyrus\EventSourcing\EventSourceableAggregateRootTrait;
use Papyrus\EventSourcing\EventSourcedAggregateRoot;

final class YourAggregateRoot implements EventSourcedAggregateRoot
{
    use EventSourceableAggregateRootTrait;
    
    // Only add properties when they influence state
    private YourAggregateRootId $yourAggregateRootId;
    
    // No need for the public __construct()
    // Create a domain understandable named constructor instead
    public static function open(YourAggregateRootId $yourAggregateRootId, string $somethingElse): self
    {
        $aggregateRoot = new self();
        $aggregateRoot->apply(new YourAggregateRootOpenedEvent(
            (string) $yourAggregateRootId, // Add primitives only to avoid indirect hidden event mutability
            $somethingElse
        ));
        
        return $aggregateRoot;
    }
    
    // Other behavioral methods
    // ...
    
    public function doSomething(string $something): void
    {
        // Check idempotency
        // Protect invariants
        
        $this->apply(new SomethingHappenedEvent((string) $yourAggregateRootId, $something));
    }
    
    // (Optional) apply* event methods for state-influencing parameters 
    protected function applyYourAggregateRootOpenedEvent(YourAggregateRootOpenedEvent $event): void
    {
        $this->yourAggregateRootId = new YourAggregateRootId($event->yourAggregateRootId);
        // other state-influencing parameters
        // ...
    }
}

// A domain event
final class YourAggregateRootOpenedEvent implements DomainEvent
{
    public function __construct(
        public readonly string $yourAggregateRootId,
        public readonly string $somethingElse,
    ) {}
    
    public function getEventName(): string
    {
        return 'your_aggregate_root.opened';
    }

    public function getAggregateRootId(): string
    {
        return $this->yourAggregateRootId;
    }
}

// The aggregate root identifier VO
final class YourAggregateRootId implements AggregateRootId
{
    // your implementation
    
    public function __toString(): string
    {
        return '';
    }
}
```

### Persistence (Event store)
Without persisting the applied events of the aggregate root, we cannot really speak of event-sourcing 😉 (sometimes you want event-driven aggregate roots without event sourcing...).

You can create your own repository, but you can also use _Papyrus_'s library to persist.
How to work with this library, see [papyrus/event-store](https://github.com/papyrusphp/event-store).
