<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 08.
 * Time: 15:38
 */

namespace MedevSlim\Core\APIService;


use MedevSlim\Core\APIService\Interfaces\ServiceConfiguration;
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
        $group = $app->group($baseUrl, function()use ($app,$service){
            $service->registerRoutes($app);
        });
        $this->registerMiddlewares($group);
    }

    protected abstract function registerRoutes(App $app);

    protected abstract function registerMiddlewares(RouteGroupInterface $group);
}