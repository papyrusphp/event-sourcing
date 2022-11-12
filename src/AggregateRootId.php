<?php

declare(strict_types=1);

namespace Papyrus\EventSourcing;

use Stringable;

interface AggregateRootId extends Stringable
{
    public function __toString(): string;
}
