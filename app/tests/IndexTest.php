<?php

use PHPUnit\Framework\TestCase;

class IndexTest extends TestCase
{
    /**
     * @group xieyong
     */
    public function testExpectFooActualFoo()
    {
        $this->expectOutputString('foo');
        print 'foo';
    }

    public function testExpectBarActualBaz()
    {
        $this->expectOutputString('bar');
        print 'baz';
    }
}
