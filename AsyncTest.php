<?php

use PHPUnit\Framework\TestCase;

class AsyncTest extends TestCase
{
    public function testAsyncSimulation()
    {
        // Capture output
        ob_start();
        include 'async.php';
        $output = ob_get_clean();

        // Assert the final message appears
        $this->assertStringContainsString('✅ All tasks completed', $output);
    }
}
