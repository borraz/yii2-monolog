<?php

namespace Borraz\Monolog\Exception;

class HandlerNotFoundExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Borraz\Monolog\Exception\HandlerNotFoundException
     */
    public function testThrowException()
    {
        throw new HandlerNotFoundException();
    }
}
