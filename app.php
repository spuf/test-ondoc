<?php

require __DIR__ . '/vendor/autoload.php';

$startDate = new DateTime($argv[1]);
$consumeDays = intval($argv[2]);
$skipDays = intval($argv[3]);

$piller = new TestOndoc\Piller($startDate, $consumeDays, $skipDays);

$now = new DateTime();
$nextDate = $piller->getNextConsumeDate($now);

print $nextDate->format('Y-m-d');
