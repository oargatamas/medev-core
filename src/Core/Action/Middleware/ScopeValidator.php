<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:42
 */

namespace MedevSlim\Core\Action\Middleware;


use MedevSlim\Core\Service\Exceptions\UnauthorizedException;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class ScopeValidator
 * @package MedevSlim\Core\Action\Middleware
 */
class ScopeValidator
{
    /**
     * @var array
     */
    private $requiredScopes;


    /**
     * ScopeValidator constructor.
     * @param array|null $requiredScopes
     */
    public function __construct(array $requiredScopes = null)
    {
        $this->requiredScopes = $requiredScopes;
    }


    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     * @throws UnauthorizedException
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $scopesInRequest = $request->getAttribute("scopes",[]);
        if(!$this->hasPermission($scopesInRequest)){
            throw new UnauthorizedException();
        }
        return $next($request, $response);
    }


    /**
     * @param $permissionsFromClient
     * @return bool
     */
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
}