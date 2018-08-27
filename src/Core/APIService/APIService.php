<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 08.
 * Time: 15:38
 */

namespace MedevSuite\Core\APIService;


use MedevSuite\Core\APIService\Interfaces\ServiceConfiguration;
use Slim\App;

abstract class APIService
{

    protected $config;
    protected $requires_authentication;


    public function __construct(ServiceConfiguration $config = null)
    {
        $this->config = $config;
    }


    public function register(App $app,$baseUrl = "/"){
        $this->registerRoutes($app,$baseUrl);
        $this->registerMiddlewares($app);
    }

    protected abstract function registerRoutes(App $app);
    protected abstract function registerMiddlewares(App $app);
}