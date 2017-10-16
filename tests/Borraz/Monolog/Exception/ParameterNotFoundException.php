<?php

namespace Borraz\Monolog\Exception;

class ParameterNotFoundException extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Borraz\Monolog\Exception\ParameterNotFoundException
     */
    public function testThrowException()
    {
        throw new LoggerNotFoundException();
    }
}
