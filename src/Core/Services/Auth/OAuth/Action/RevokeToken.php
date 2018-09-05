<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 05.
 * Time: 11:03
 */

namespace MedevSlim\Core\Services\Auth\OAuth\Action;


use MedevSlim\Core\APIAction\APIAction;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class RevokeToken extends APIAction
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container, ["revoke_token"]);
    }


    protected function onPermissionGranted(Request $request, Response $response, $args)
    {

    }
}