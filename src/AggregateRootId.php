<?php

declare(strict_types=1);

namespace Papyrus\EventSourcing;

interface AggregateRootId
{
    public function __toString(): string;
}
