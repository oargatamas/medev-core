<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:30
 */

namespace MedevSlim\Core\ErrorHandlers;


use MedevSlim\Core\Application\MedevApp;
use MedevSlim\Core\DependencyInjection\DependencyInjector;
use MedevSlim\Core\Logging\LogContainer;
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
     * @return Response
     */
    public function __invoke(Request $request, Response $response) {
        $uniqueId = $this->app->getRequestId();
        $channel = $this->app->getLogChannel();

        $this->logger->error($channel,$uniqueId,"Route not found: " .$request->getUri()->__toString());

        return $response
            ->withStatus(404)
            ->withJson("Content not found");
    }

    /**
     * @param ContainerInterface $container
     */
    static function inject(ContainerInterface $container)
    {
        $container["notFoundHandler"] = function (ContainerInterface $container){
            return new NotFoundHandler($container);
        };
    }
}