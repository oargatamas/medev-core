<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:31
 */

namespace MedevSlim\Core\ErrorHandlers;


use MedevSlim\Core\DependencyInjection\DependencyInjector;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class NotAllowedHandler
 * @package MedevSlim\Core\ErrorHandlers
 */
class NotAllowedHandler implements DependencyInjector
{

    /**
     * @var Logger
     */
    private $logger;

    /**
     * PHPRuntimeHandler constructor.
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $methods
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $methods) {
        $this->logger->log(Logger::ERROR,"Method not allowed", [$methods]);

        return $response
            ->withStatus(405)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode("Method not allowed"));
    }

    /**
     * @param ContainerInterface $container
     */
    static function inject(ContainerInterface $container)
    {
        $container["notAllowedHandler"] = function () use ($container) {
            return new NotAllowedHandler($container["logger"]);
        };
    }
}