<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 16.
 * Time: 14:30
 */

namespace MedevSlim\Core\APIAction;


use MedevSlim\Core\APIService\Exceptions\UnauthorizedException;
use Psr\Container\ContainerInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class APIAction
{
    private $permissions;
    protected $container;


    public function __construct(ContainerInterface $container,$permissions = [])
    {
        $this->container = $container;
        $this->permissions = $permissions;
    }

    public function __invoke(Request $request,Response $response, $args)
    {
        if ($this->hasPermission($request->getAttribute("scopes"))) {
            return $this->onPermissionGranted($request, $response, $args);
        } else {
            throw new UnauthorizedException();
        }
    }


    private function hasPermission($permissionsFromClient)
    {
        if (empty($this->permissions)) { //If we did not set any permission, then we are Authorised! :)
            return true;
        }

        foreach ($permissionsFromClient as $clientScope){
            foreach ($this->permissions as $requiredScope){
                if($clientScope === $requiredScope){
                    return true; // We found the matching permission id -> Authorised request!
                }
            }
        }

        //we had no case when we can return with true -> Unauthorised request!
        return false;
    }

    protected abstract function onPermissionGranted(Request $request,Response $response, $args);
}