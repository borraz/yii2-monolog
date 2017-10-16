<?php

namespace Borraz\Monolog\Handler;

use Borraz\Monolog\Exception\HandlerNotFoundException;
use Borraz\Monolog\Exception\ParameterNotFoundException;
use Borraz\Monolog\Handler\Factory\AbstractFactory;
use Borraz\Monolog\Handler\Factory\BrowserConsoleFactory;
use Borraz\Monolog\Handler\Factory\ChromePHPFactory;
use Borraz\Monolog\Handler\Factory\FirePHPFactory;
use Borraz\Monolog\Handler\Factory\GelfFactory;
use Borraz\Monolog\Handler\Factory\HipChatFactory;
use Borraz\Monolog\Handler\Factory\RotatingFileFactory;
use Borraz\Monolog\Handler\Factory\SlackFactory;
use Borraz\Monolog\Handler\Factory\SocketFactory;
use Borraz\Monolog\Handler\Factory\StreamFactory;
use Borraz\Monolog\Handler\Factory\SyslogFactory;
use Borraz\Monolog\Handler\Factory\SyslogUdpFactory;
use Borraz\Monolog\Handler\Factory\YiiDbFactory;
use Borraz\Monolog\Handler\Factory\YiiMongoFactory;
use Monolog\Logger;

class Strategy
{
    /**
     * @var array Handler factory collection
     */
    protected $factories;

    public function __construct()
    {
        $this->factories = [
            'stream' => StreamFactory::className(),
            'firephp' => FirePHPFactory::className(),
            'browser_console' => BrowserConsoleFactory::className(),
            'gelf' => GelfFactory::className(),
            'chromephp' => ChromePHPFactory::className(),
            'rotating_file' => RotatingFileFactory::className(),
            'yii_db' => YiiDbFactory::className(),
            'yii_mongo' => YiiMongoFactory::className(),
            'hipchat' => HipChatFactory::className(),
            'slack' => SlackFactory::className(),
            'elasticsearch' => '',
            'fingers_crossed' => '',
            'filter' => '',
            'buffer' => '',
            'deduplication' => '',
            'group' => '',
            'whatfailuregroup' => '',
            'syslog' => SyslogFactory::className(),
            'syslogudp' => SyslogUdpFactory::className(),
            'swift_mailer' => '',
            'socket' => SocketFactory::className(),
            'pushover' => '',
            'raven' => '',
            'newrelic' => '',
            'cube' => '',
            'amqp' => '',
            'error_log' => '',
            'null' => '',
            'test' => '',
            'debug' => '',
            'loggly' => '',
            'logentries' => '',
            'flowdock' => '',
            'rollbar' => '',
        ];
    }

    /**
     * Verifies that the factory class exists.
     *
     * @param string $type Name of type
     *
     * @return bool
     *
     * @throws HandlerNotFoundException When handler factory not found
     * @throws \BadMethodCallException  When handler not implemented
     */
    protected function hasFactory($type)
    {
        if (!array_key_exists($type, $this->factories)) {
            throw new HandlerNotFoundException(
                sprintf("Type '%s' not found in handler factory", $type)
            );
        }
        $factoryClass = &$this->factories[$type];
        if (!class_exists($factoryClass)) {
            throw new \BadMethodCallException(
                sprintf("Type '%s' not implemented", $type)
            );
        }

        return true;
    }

    /**
     * Create a factory object.
     *
     * @param array $config Configuration parameters
     *
     * @return AbstractFactory Factory object
     *
     * @throws ParameterNotFoundException When required parameter not found
     */
    public function createFactory(array $config)
    {
        if (!array_key_exists('type', $config)) {
            throw new ParameterNotFoundException(
                sprintf("Parameter '%s' not found in handler configuration", 'type')
            );
        }
        $this->hasFactory($config['type']);
        if (isset($config['level'])) {
            $config['level'] = Logger::toMonologLevel($config['level']);
        }

        $factoryClass = &$this->factories[$config['type']];

        return new $factoryClass($config);
    }
}
