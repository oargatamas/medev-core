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
use MedevSuite\Application\Auth\OAuth\Token\TokenProvider;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Interfaces\RouteGroupInterface;

class OAuthService extends APIService
{
    const KEY_ACCESS_TOKEN = "accessToken";
    const KEY_REFRESH_TOKEN = "refreshToken";

    private $grantTypes;
    private $tokenProviders;

    public function __construct(ServiceConfiguration $config = null)
    {
        $this->grantTypes = [];
        $this->tokenProviders = [];
        parent::__construct($config);
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
        $grantType->setAuthService($this);
        $this->grantTypes[$grantType->getName()] = $grantType;
    }

    public function hasGrantType($grantType = ""){
        return isset($this->grantTypes[$grantType]);
    }

    public function getGrantType($type){
        return $this->grantTypes[$type];
    }


    public function addTokenProvider(TokenProvider $provider, $purposeKey){
        $this->tokenProviders[$purposeKey] = $provider;
    }

    public function getTokenProvider($purposeKey){
        return $this->tokenProviders[$purposeKey];
    }
}