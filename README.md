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
It is not meant to use directly in your domain layer.

**Don't use this code!** 🙃

Questions, ideas and change requests are always welcome 🤗
