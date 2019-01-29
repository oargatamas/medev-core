<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:31
 */

namespace MedevSlim\Core\ErrorHandlers;


use MedevSlim\Core\Application\MedevApp;
use MedevSlim\Core\DependencyInjection\DependencyInjector;
use MedevSlim\Core\Logging\LogContainer;
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
     * @var MedevApp
     */
    private $app;

    /**
     * @var LogContainer
     */
    private $logger;

    /**
     * PHPRuntimeHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->app = $container->get(MedevApp::class);
        $this->logger = $container->get(LogContainer::class);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $methods
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $methods) {
        $uniqueId = $this->app->getUniqueId();
        $channel = $this->app->getChannel();

        $logData = [
            "Allowed methods" => $methods,
            "Request data" => [
                $request->getMethod(),
                (string)$request->getUri()
            ]
        ];

        $this->logger->error($channel,$uniqueId,"Method not allowed.", $logData);

        return $response
            ->withStatus(405)
            ->withJson("Method not allowed");
    }

    /**
     * @param ContainerInterface $container
     */
    static function inject(ContainerInterface $container)
    {
        $container["notAllowedHandler"] = function (ContainerInterface $container){
            return new NotAllowedHandler($container);
        };
    }
}