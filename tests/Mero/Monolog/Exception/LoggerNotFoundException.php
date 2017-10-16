<?php

namespace Borraz\Monolog\Exception;

class LoggerNotFoundException extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Borraz\Monolog\Exception\LoggerNotFoundException
     */
    public function testThrowException()
    {
        throw new self();
    }
}
