<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:30
 */

namespace MedevSlim\Core\ErrorHandlers;


use MedevSlim\Core\DependencyInjection\DependencyInjector;
use MedevSlim\Core\Logging\LogContainer;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class NotFoundHandler
 * @package MedevSlim\Core\ErrorHandlers
 */
class NotFoundHandler implements DependencyInjector
{

    /**
     * @var LogContainer
     */
    private $logger;

    /**
     * PHPRuntimeHandler constructor.
     * @param Logger $logger
     */
    public function __construct(LogContainer $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response) {

        $this->logger->log(Logger::ERROR,"Route not found", [$request->getUri()->__toString()]);

        return $response
            ->withStatus(404)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode("Content not found"));
    }

    /**
     * @param ContainerInterface $container
     */
    static function inject(ContainerInterface $container)
    {
        $container["notFoundHandler"] = function () use ($container) {
            return new NotFoundHandler($container[LogContainer::class]);
        };
    }
}