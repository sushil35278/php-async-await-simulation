<?php
require 'vendor/autoload.php';

use React\EventLoop\Factory;
use React\Promise\Deferred;

// Simulated async operation
function asyncOperation(string $name, float $delaySeconds)
{
    $deferred = new Deferred();
    $loop = React\EventLoop\Loop::get();

    $loop->addTimer($delaySeconds, function () use ($deferred, $name, $delaySeconds) {
        echo "[{$name}] Completed after {$delaySeconds} seconds\n";
        $deferred->resolve("Result: $name");
    });

    return $deferred->promise();
}

// Test function simulating 'await' behavior
function runTest()
{
    asyncOperation("Task 1", 1)
        ->then(function ($result1) {
            echo "[Test] Got: $result1\n";
            return asyncOperation("Task 2", 2);
        })
        ->then(function ($result2) {
            echo "[Test] Got: $result2\n";
            return asyncOperation("Task 3", 1);
        })
        ->then(function ($result3) {
            echo "[Test] Got: $result3\n";
            echo "[Test] ✅ All tasks completed.\n";
        });
}

// Start the loop
$loop = Factory::create();
React\EventLoop\Loop::set($loop);
runTest();
$loop->run();
