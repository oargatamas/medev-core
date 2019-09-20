<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 09. 20.
 * Time: 14:51
 */

namespace MedevSlim\Core\Action\Middleware;


use MedevSlim\Core\Application\MedevApp;
use MedevSlim\Core\Logging\LogContainer;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class AppMiddleware
{
    /**
     * @var MedevApp
     */
    protected $app;

    /**
     * @var LogContainer
     */
    protected $logger;

    /**
     * @var array
     */
    protected $config;


    /**
     * RequestLogger constructor.
     * @param MedevApp $app
     */
    public function __construct(MedevApp $app)
    {
        $this->app = $app;
        $this->config = $app->getConfiguration();
        $this->logger = $app->getLogContainer();
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    public abstract function __invoke(Request $request, Response $response, callable $next);
}