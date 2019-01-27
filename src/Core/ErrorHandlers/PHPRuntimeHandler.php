<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:27
 */

namespace MedevSlim\Core\ErrorHandlers;


use MedevSlim\Core\Action\RequestAttribute;
use MedevSlim\Core\DependencyInjection\DependencyInjector;
use MedevSlim\Core\Logging\LogContainer;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class PHPRuntimeHandler
 * @package MedevSlim\Core\ErrorHandlers
 */
class PHPRuntimeHandler implements DependencyInjector
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var LogContainer
     */
    private $logContainer;

    /**
     * PHPRuntimeHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->logContainer = $this->container->get(LogContainer::class);
    }


    /**
     * @param Request $request
     * @param Response $response
     * @param $exception
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $exception) {
        $this->logContainer->error($request->getAttribute(RequestAttribute::HANDLER_SERVICE),"Error during request handling: ",[$exception]);

        return $response
            ->withStatus(500)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode("Something went wrong."));
    }

    /**
     * @param ContainerInterface $container
     */
    static function inject(ContainerInterface $container)
    {
        $container["phpErrorHandler"] = function () use ($container) {
            return new PHPRuntimeHandler($container);
        };
    }
}