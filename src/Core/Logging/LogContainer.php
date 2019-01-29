<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 01. 26.
 * Time: 11:37
 */

namespace MedevSlim\Core\Logging;


use MedevSlim\Core\Action\RequestAttribute;
use MedevSlim\Core\DependencyInjection\DependencyInjector;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;

/**
 * Class LogContainer
 * @package MedevSlim\Core\Logging
 */
class LogContainer implements DependencyInjector
{
    const DEFAULT_LOGGER_CHANNEL = "ApplicationDefault";
    const LOG_FILE_FORMAT = "[%datetime%][%channel%][%context.CorrelationId%][%level_name%] %message%\n";

    /**
     * @var Logger[]
     */
    private $loggers;

    /**
     * @var Logger
     */
    private $defaultLogger;

    /**
     * LogContainer constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->loggers = [];
        $logger = new Logger(self::DEFAULT_LOGGER_CHANNEL);
        $logger->pushHandler(new StreamHandler($_SERVER['DOCUMENT_ROOT'] . "/../log/" . self::DEFAULT_LOGGER_CHANNEL . ".log", Logger::DEBUG));
        $this->defaultLogger = $logger;
    }

    /**
     * @param Logger $logger
     */
    public function addLogger(Logger $logger)
    {
        $this->loggers[$logger->getName()] = $logger;
    }

    /**
     * @param Logger $logger
     */
    public function removeLogger(Logger $logger)
    {
        unset($this->loggers[$logger->getName()]);
    }

    /**
     * @param string $channel
     * @return Logger
     */
    private function getLogger($channel)
    {
        return array_key_exists($channel, $this->loggers) ? $this->loggers[$channel] : $this->defaultLogger;
    }

    /**
     * @param string $channel
     * @param int $loglevel
     * @param string $correlationId
     * @param string $message
     * @param array $args
     */
    public function log($channel, $loglevel, $correlationId, $message, $args = [])
    {
        $logger = $this->getLogger($channel);
        $args[RequestAttribute::CORRELATION_ID] = $correlationId;
        $logger->log($loglevel, $message, $args);
    }

    /**
     * @param string $channel
     * @param string $correlationId
     * @param string $message
     * @param array $args
     */
    public function debug($channel, $correlationId, $message, $args = [])
    {
        $this->log($channel, Logger::DEBUG, $correlationId, $message, $args);
    }

    /**
     * @param string $channel
     * @param string $correlationId
     * @param string $message
     * @param array $args
     */
    public function info($channel, $correlationId, $message, $args = [])
    {
        $this->log($channel, Logger::INFO, $correlationId, $message, $args);
    }

    /**
     * @param string $channel
     * @param string $correlationId
     * @param string $message
     * @param array $args
     */
    public function warn($channel, $correlationId, $message, $args = [])
    {
        $this->log($channel, Logger::WARNING, $correlationId, $message, $args);
    }

    /**
     * @param string $channel
     * @param string $correlationId
     * @param string $message
     * @param array $args
     */
    public function error($channel, $correlationId, $message, $args =[])
    {
        $this->log($channel, Logger::ERROR, $correlationId, $message, $args);
    }

    /**
     * @param ContainerInterface $container
     */
    static function inject(ContainerInterface $container)
    {
        $container[LogContainer::class] = function (){
            return new LogContainer();
        };
    }
}