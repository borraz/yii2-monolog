<?php

namespace Borraz\Monolog\Handler\Factory;

use Monolog\Logger;

class StreamFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function dataProviderParameterNotFound()
    {
        return [
            [
                [
                    'type' => 'stream',
                    'level' => Logger::DEBUG,
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderParameterNotFound
     * @expectedException \Borraz\Monolog\Exception\ParameterNotFoundException
     */
    public function testParameterNotFound(array $params)
    {
        new StreamFactory($params);
    }

    public function testCreateHandler()
    {
        $factory = new StreamFactory([
            'type' => 'stream',
            'path' => 'test',
            'level' => Logger::DEBUG,
        ]);
        $handler = $factory->createHandler();
        $this->assertInstanceOf('Monolog\Handler\StreamHandler', $handler);
    }
}
