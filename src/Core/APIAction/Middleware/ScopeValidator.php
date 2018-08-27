<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:42
 */

namespace MedevSuite\Core\APIAction\Middleware;


class ScopeValidator
{
    private $requiredScopes;


    public function __construct(array $requiredScopes = null)
    {
        $this->$requiredScopes = $requiredScopes;
    }


    public function __invoke($request, $response, $next)
    {
        $response->getBody()->write('BEFORE ScopeValidator');
        $response = $next($request, $response);
        $response->getBody()->write('AFTER ScopeValidator');

        return $response;
    }
}