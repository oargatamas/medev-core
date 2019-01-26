<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 01. 26.
 * Time: 11:37
 */

namespace MedevSlim\Core\Logging;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class LogContainer
 * @package MedevSlim\Core\Logging
 */
class LogContainer
{
    const DEFAULT_LOGGER_CHANNEL = "ApplicationDefault";

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
     * @param string $message
     * @param array $args
     */
    public function log($channel, $loglevel, $message, $args)
    {
        $logger = $this->getLogger($channel);
        $logger->log($loglevel, $message, $args);
    }

    /**
     * @param string $channel
     * @param string $message
     * @param array $args
     */
    public function debug($channel, $message, $args)
    {
        $this->log($channel, Logger::DEBUG, $message, $args);
    }

    /**
     * @param string $channel
     * @param string $message
     * @param array $args
     */
    public function info($channel, $message, $args)
    {
        $this->log($channel, Logger::INFO, $message, $args);
    }

    /**
     * @param string $channel
     * @param string $message
     * @param array $args
     */
    public function warn($channel, $message, $args)
    {
        $this->log($channel, Logger::WARNING, $message, $args);
    }

    /**
     * @param string $channel
     * @param string $message
     * @param array $args
     */
    public function error($channel, $message, $args)
    {
        $this->log($channel, Logger::ERROR, $message, $args);
    }
}