<?php

use PHPUnit\Framework\TestCase;

class IndexTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     */
    public function testConsumer($a, $b, $c)
    {
        $this->assertEquals($c, $a + $b);
    }

    public function additionProvider()
    {
        return [
            [0, 0, 0],
            [0, 1, 1],
            [1, 0, 1],
            [1, 1, 3],
        ];
    }
}
