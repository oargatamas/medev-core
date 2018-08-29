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
        $group = $app->group($baseUrl, function () {
            $this->registerRoutes($this);
        })->setName($this->getServiceName());

        $this->registerMiddlewares($group);
    }

    protected abstract function getServiceName();

    protected abstract function registerRoutes(App $app);

    protected abstract function registerMiddlewares(RouteGroup $group);
}