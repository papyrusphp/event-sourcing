# 📜 Papyrus Event Sourcing
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE)
[![PHP Version](https://img.shields.io/badge/php-%5E8.1-8892BF.svg?style=flat)](http://www.php.net)

Yet another event sourcing library for PHP.

### Why another library?
There are already great libraries for event sourcing in PHP,
like [Broadway](https://github.com/broadway/broadway), [EventSauce](https://github.com/EventSaucePHP/EventSauce) and [Prooph](https://github.com/prooph/event-sourcing).

However, they never fitted well in projects. 

> _Your domain layer should not depend on external packages._

The biggest drawback all these libraries have, is that it introduces an external dependency in your domain layer.
In a [Clean Architecture](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html) (or [Hexagonal Architecture](https://alistair.cockburn.us/hexagonal-architecture/)) approach,
the domain layer is the most inner layer, which should not depend on anything.

With _Papyrus_ you will need to create the necessary domain layer classes yourself.
Papyrus only provides an event store, in order to persist your event driven aggregate root.

However, this repository (which you're reading now) does contain code;
as an example of how you can create the necessary domain layer classes
in order to use [papyrus/event-store](https://github.com/papyrusphp/event-store).
You can copy these classes or create your own. 

This repository is not meant to use directly via composer in your domain layer. 🙃

Questions, ideas and change requests are always welcome 🤗

### How to use
A **simplified** example aggregate root, using the example classes in `/src`:
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
Without persisting the applied events of the aggregate root, we cannot really speak of event-sourcing 😉
(sometimes you want event-driven aggregate roots without event sourcing...).

For implementation details, see [papyrus/event-store](https://github.com/papyrusphp/event-store).
