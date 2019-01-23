<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 08.
 * Time: 15:38
 */

namespace MedevSlim\Core\APIService;


use MedevSlim\Core\APIAction\Middleware\RequestLogger;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use RKA\Middleware\IpAddress;
use Slim\App;
use Slim\Interfaces\RouteGroupInterface;

abstract class APIService
{

    /**
     * @var App
     */
    protected $application;
    /**
     * @var Logger
     */
    protected $logger;

    public function __construct(App $app)
    {
        $this->application = $app;
    }

    public abstract function getServiceName();


    public function register($baseUrl = "/")
    {
        $service = $this;
        $app = $this->application;
        $container = $app->getContainer();

        $this->registerContainerComponents($container);
        
        $group = $app->group($baseUrl, function()use ($app,$container,$service){
            $service->registerRoutes($app,$container);
        });
        $this->registerMiddlewares($group,$container);

        $group->add(new RequestLogger($this->getLogger()));
        $group->add(new IpAddress());
    }

    protected abstract function registerRoutes(App $app,ContainerInterface $container);

    protected function registerMiddlewares(RouteGroupInterface $group, ContainerInterface $container){
        //Do nothing
    }

    protected function registerContainerComponents(ContainerInterface $container){
        //Do nothing
    }

    protected abstract function getLogger();
}