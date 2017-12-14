<?php

require __DIR__.'/../vendor/autoload.php';

function display_result(array $eventsCount)
{
    $result = [];
    foreach ($eventsCount as $eventId => $count) {
        if (!isset($result[$count])) {
            $result[$count] = 0;
        }
        ++$result[$count];
    }

    array_walk($result, function($events, $count) {
        printf("%d events were applied %d times.\n", $events, $count);
    });
}

$pdo = new \PDO('pgsql:host=pgsql;dbname=dev', 'dev', 'dev');
$eventStore = new \Prooph\EventStore\ActionEventEmitterEventStore(
    new \Prooph\EventStore\Pdo\PostgresEventStore(
        new \Prooph\Common\Messaging\FQCNMessageFactory(),
        $pdo,
        new \Prooph\EventStore\Pdo\PersistenceStrategy\PostgresAggregateStreamStrategy()
    ),
    new \Prooph\Common\Event\ProophActionEventEmitter(\Prooph\EventStore\ActionEventEmitterEventStore::ALL_EVENTS)
);
$aggregateType = \Prooph\EventSourcing\Aggregate\AggregateType::fromAggregateRootClass(\App\Model\MyAggregate::class);
$aggregateTranslator = new \Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator();
$streamName = new \Prooph\EventStore\StreamName('my_aggregate');

/**
 * WITHOUT SNAPSHOT
 */
$repository = new \App\Infrastructure\Repository\EventStoreMyAggregateCollection(
    $eventStore,
    $aggregateType,
    $aggregateTranslator,
    null,
    $streamName,
    true
);

echo "Repository without snapshot store\n";
display_result($repository->get()->eventsCount());

/**
 * WITH SNAPSHOT
 */
$snapshotStore = new \Prooph\SnapshotStore\Pdo\PdoSnapshotStore($pdo, [
    \App\Model\MyAggregate::class => 'snapshots',
]);
$repository = new \App\Infrastructure\Repository\EventStoreMyAggregateCollection(
    $eventStore,
    $aggregateType,
    $aggregateTranslator,
    $snapshotStore,
    $streamName,
    true
);

/**
 * Create snapshot
 */
$projectionManager = new \Prooph\EventStore\Pdo\Projection\PostgresProjectionManager($eventStore, $pdo);
$projection = new \Prooph\Snapshotter\CategorySnapshotProjection(
    $projectionManager->createReadModelProjection(
        'snapshots',
        new \Prooph\Snapshotter\SnapshotReadModel(
            $repository,
            $aggregateTranslator,
            $snapshotStore,
            [\App\Model\MyAggregate::class]
        )
    ),
    'my_aggregate'
);
$projection(false);

echo "\nRepository with snapshot store\n";
display_result($repository->get()->eventsCount());
