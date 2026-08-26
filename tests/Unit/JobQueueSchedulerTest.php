<?php
declare(strict_types=1);

require_once __DIR__ . '/../../core/bootstrap.php';

use Vedairo\Schedule\Scheduler;

// Test Scheduler
$scheduler = new Scheduler();
$ranScheduled = false;
$scheduler->everyMinute(function() use (&$ranScheduled) {
    $ranScheduled = true;
});

$dueTasks = $scheduler->due();
assert(count($dueTasks) === 1, 'Scheduler should have 1 task due');
assert($dueTasks[0]['interval'] === 60);

$scheduler->runDue();
assert($ranScheduled === true, 'Scheduled task was not executed');

echo "JobQueueSchedulerTest: PASS\n";
return true;

