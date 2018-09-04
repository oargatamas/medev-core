<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 02.
 * Time: 20:30
 */

namespace MedevSlim\Core\Services\Auth\OAuth\Action;


use MedevSlim\Core\APIAction\APIAction;
use MedevSlim\Core\APIService\Exceptions\ForbiddenException;
use MedevSlim\Core\Services\Auth\OAuth\OAuthService;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class GrantAccess extends APIAction
{
    private $authService;

    public function __construct(ContainerInterface $container,OAuthService $authService)
    {
        $this->authService = $authService;
        parent::__construct($container, []);
    }


    protected function executeLogic(Request $request, Response $response, $args)
    {
        if(!$request->get("grant_type")){
            throw new ForbiddenException();
        }

        if(!$this->authService->hasGrantType($request->getHeader("grant_type"))){
            throw new ForbiddenException();
        }

        $handler = $this->authService->getGrantType($request->getHeader("grant_type"));
        return $handler($request,$response,$args);
    }
}