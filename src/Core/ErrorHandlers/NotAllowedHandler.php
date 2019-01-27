<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:31
 */

namespace MedevSlim\Core\ErrorHandlers;


use MedevSlim\Core\Action\RequestAttribute;
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
     * @var LogContainer
     */
    private $logger;

    /**
     * PHPRuntimeHandler constructor.
     * @param LogContainer $logger
     */
    public function __construct(LogContainer $logger)
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
        $this->logger->error($request->getAttribute(RequestAttribute::HANDLER_SERVICE),"Method not allowed", [$methods]);

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
            return new NotAllowedHandler($container[LogContainer::class]);
        };
    }
}