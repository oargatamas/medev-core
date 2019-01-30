<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:42
 */

namespace MedevSlim\Core\Action\Middleware;


use MedevSlim\Core\Action\RequestAttribute;
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
     * @param string[] $requiredScopes
     */
    public function __construct($requiredScopes)
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
        $scopesInRequest = $request->getAttribute(RequestAttribute::SCOPES,[]);
        if(!$this->hasPermission($scopesInRequest)){
            throw new UnauthorizedException("The following scope(s) needed for action [".implode(", ",$this->requiredScopes)."], but those found in request [".implode(", ",$scopesInRequest)."].");
        }
        return $next($request, $response);
    }


    /**
     * @param string[] $scopesFromClient
     * @return bool
     */
    private function hasPermission($scopesFromClient)
    {
        if (empty($this->requiredScopes)) { //If we did not set any permission, then we are Authorized! :)
            return true;
        }

        if(empty(array_diff($this->requiredScopes,$scopesFromClient))){
            return true; //We found all the matching scopes -> Authorized request!
        }

        return false; //We had no case when we can return with true -> Unauthorized request!
    }
}