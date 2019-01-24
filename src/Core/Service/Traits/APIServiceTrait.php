<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 09.
 * Time: 11:39
 */

namespace MedevSlim\Core\Service\Traits;


use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Interfaces\RouteGroupInterface;

trait APIServiceTrait
{
    public function register(App $app,$baseUrl = "/")
    {
        $service = $this;
        $container = $app->getContainer();

        $this->registerDIComponents($container);

        $group = $app->group($baseUrl, function()use ($app,$container,$service){
            $service->registerRoutes($app,$container);
        });
        $this->registerMiddlewares($group,$container);
    }

    protected abstract function registerRoutes(App $app,ContainerInterface $container);

    protected abstract function registerMiddlewares(RouteGroupInterface $group, ContainerInterface $container);

    protected abstract function registerDIComponents(ContainerInterface $container);
}