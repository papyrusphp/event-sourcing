<?php

declare(strict_types=1);

namespace Papyrus\EventSourcing;

interface AggregateRoot
{
    public function getAggregateRootId(): AggregateRootId;
}
