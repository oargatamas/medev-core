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

abstract class APIService
{

    protected $config;
    protected $requires_authentication;


    public function __construct(ServiceConfiguration $config = null)
    {
        $this->config = $config;
    }


    public function register(App $app, $baseUrl = "/")
    {
        $app->group($baseUrl, $this->registerRoutes())->add($this->registerMiddlewares($app));
    }

    protected abstract function registerRoutes();

    protected abstract function registerMiddlewares(App $app);
}