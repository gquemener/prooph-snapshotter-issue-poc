<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use Prooph\EventSourcing\Aggregate\AggregateRepository;
use App\Model\MyAggregate;

final class EventStoreMyAggregateCollection extends AggregateRepository
{
    public function get(): ?MyAggregate
    {
        return $this->getAggregateRoot(MyAggregate::ID);
    }
}
