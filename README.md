# Prooph Snapshotter issue

This POC intends to provide a reproducable environment in which events are applied multiple times to the same aggregate root.

To read more about the issue, please follow [this link](https://github.com/prooph/snapshotter/issues/30).

## Description

This environment (described with the [Docker compose](https://docs.docker.com/compose/overview/) tool) provides 2 services

### `php`
A php 7.1 container containing containing a script (in `bin/demo.php`) demonstrating the issue.

### `pgsql`
A postgres database containing a set of data leading to the issue.

It basically describes an event stream containing 1006 events, a projection and a snapshot table.

This two last tables are populated when running the demo script.

## Getting started

```
$ docker-compose up -d
```

This will build and create both services (pgsql db, tables and data are autocreated on service start).

## Running the script

You can run the demo script by running:

```
$ docker-compose run --rm php php bin/demo.php
```

You should then see:

```
Repository without snapshot store
1006 events were applied 1 times.

Repository with snapshot store
1000 events were applied 2 times.
6 events were applied 3 times.
```
