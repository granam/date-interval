DateInterval
============

[![Build Status](https://travis-ci.org/jaroslavtyc/granam-date-interval.png)](http://travis-ci.org/jaroslavtyc/granam-date-interval)

Provides additional functionality to the DateInterval class.

Usage
-----

```php
<?php

use Granam\DateInterval\DateInterval;

$interval = new DateInterval('P2H');
echo $interval->toSeconds(); // "7200"
echo $interval->toSpec(); // "P2H"

$fromSeconds = DateInterval::fromSeconds(7201);
echo $fromSeconds->toSpec(); // P2HS1
```

Summary
-------

The `DateInterval` class builds on the existing `DateInterval` class provided by PHP. With the new class, you may

- convert `DateInterval` to the [interval spec](http://php.net/manual/en/dateinterval.construct.php)
- convert `DateInterval` to the number of seconds
- convert number of seconds to `DateInterval`

Installation
------------

Add it to your list of Composer dependencies:

```sh
composer require granam/date-interval
```
