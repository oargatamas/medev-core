<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 08.
 * Time: 15:38
 */

namespace MedevSlim\Core\APIService;


use MedevSlim\Core\APIService\Interfaces\ServiceConfiguration;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Interfaces\RouteGroupInterface;
use Slim\RouteGroup;

abstract class APIService
{

    protected $config;

    public function __construct(ServiceConfiguration $config = null)
    {
        $this->config = $config;
    }


    public function register(App $app, $baseUrl = "/")
    {
        $service = $this;
        $container = $app->getContainer();
        $group = $app->group($baseUrl, function()use ($app,$container,$service){
            $service->registerRoutes($app,$container);
        });
        $this->registerMiddlewares($group,$container);
    }

    protected abstract function registerRoutes(App $app,ContainerInterface $container);

    protected abstract function registerMiddlewares(RouteGroupInterface $group, ContainerInterface $container);
}