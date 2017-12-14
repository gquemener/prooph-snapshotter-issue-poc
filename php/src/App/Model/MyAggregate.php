<?php

declare(strict_types=1);

namespace App\Model;

use Prooph\EventSourcing\AggregateRoot;
use Prooph\EventSourcing\AggregateChanged;

final class MyAggregate extends AggregateRoot
{
    const ID = 'my_only_aggregate';

    private $eventsCount = [];

    public function eventsCount(): array
    {
        return $this->eventsCount;
    }

    protected function aggregateId(): string
    {
        return self::ID;
    }

    protected function apply(AggregateChanged $event): void
    {
        if (!isset($this->eventsCount[$event->uuid()->toString()])) {
            $this->eventsCount[$event->uuid()->toString()] = 0;
        }

        ++$this->eventsCount[$event->uuid()->toString()];
    }
}
