<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 02.
 * Time: 19:39
 */

namespace MedevSlim\Core\Services\Auth\OAuth\GrantType\RefreshToken;



use MedevSlim\Core\Services\Auth\OAuth\GrantType\GrantType;
use MedevSlim\Core\Services\Auth\OAuth\Token\JWS\RefreshToken;
use MedevSlim\Core\Token\JWT\JWS\JWSConfiguration;
use MedevSuite\Application\Auth\OAuth\Token\TokenProvider;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class RefreshTokenGrant extends GrantType
{



    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container, []);
    }


    protected function executeLogic(Request $request, Response $response, $args)
    {

    }

    public function getName()
    {
        return "refresh_token";
    }
}