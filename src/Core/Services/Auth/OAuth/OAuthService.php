<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 02.
 * Time: 19:21
 */

namespace MedevSlim\Core\Services\Auth\OAuth;


use MedevSlim\Core\APIService\APIService;
use MedevSlim\Core\APIService\Interfaces\ServiceConfiguration;
use MedevSlim\Core\Services\Auth\OAuth\Action\GrantAccess;
use MedevSlim\Core\Services\Auth\OAuth\GrantType\GrantType;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Interfaces\RouteGroupInterface;

class OAuthService extends APIService
{
    private $grantTypes;


    public function __construct(App $app,ServiceConfiguration $config = null)
    {
        $this->grantTypes = [];
        parent::__construct($app,$config);
    }


    protected function registerRoutes(App $app, ContainerInterface $container)
    {
        $app->post("/token",new GrantAccess($container, $this));
    }

    protected function registerMiddlewares(RouteGroupInterface $group, ContainerInterface $container)
    {
        //No middleware needed for this service
    }

    public function addGrantType(GrantType $grantType){
        $this->grantTypes[$grantType->getName()] = $grantType;
    }

    public function hasGrantType($grantType = ""){
        return isset($this->grantTypes[$grantType]);
    }

    public function getGrantType($type){
        return $this->grantTypes[$type];
    }

}