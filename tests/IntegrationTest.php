<?php

use PHPUnit\Framework\TestCase;

class IntegrationTest extends TestCase
{
    public function testValidExec()
    {
        $arg1 = (new DateTime())->sub(new DateInterval('P3D'))->format('Y-m-d');
        $arg2 = 2;
        $arg3 = 3;
        $expected = (new DateTime())->add(new DateInterval('P2D'))->format('Y-m-d');

        exec(join(' ', [
            PHP_BINARY,
            __DIR__ . '/../app.php',
            escapeshellarg($arg1),
            escapeshellarg($arg2),
            escapeshellarg($arg3),
        ]), $output, $return);

        $this->assertEquals(0, $return);
        $this->assertCount(1, $output);
        $this->assertEquals($expected, $output[0]);
    }
}
