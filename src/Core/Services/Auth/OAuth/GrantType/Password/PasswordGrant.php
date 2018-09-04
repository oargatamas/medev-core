<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 02.
 * Time: 19:40
 */

namespace MedevSlim\Core\Services\Auth\OAuth\GrantType\Password;


use MedevSlim\Core\Services\Auth\OAuth\GrantType\GrantType;


use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class PasswordGrant extends GrantType
{

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }


    protected function executeLogic(Request $request, Response $response, $args)
    {
        $responseData = [];

        $accessToken = "";
        $refreshToken = "";

        $responseData["accessToken"] = $accessToken;
        $responseData["refreshToken"] = $refreshToken;

        $response->withJson($responseData);

        return $response;
    }

    public function getName()
    {
        return "password";
    }

    private function getAccessToken(){

    }
}