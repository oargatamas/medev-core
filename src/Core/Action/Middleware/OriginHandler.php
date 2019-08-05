<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 08. 05.
 * Time: 7:53
 */

namespace MedevSlim\Core\Action\Middleware;


use Slim\Http\Request;
use Slim\Http\Response;

class OriginHandler
{
    private $allowedOrigins;

    /**
     * OriginHandler constructor.
     * @param $allowedOrigins
     */
    public function __construct($allowedOrigins)
    {
        $this->allowedOrigins = $allowedOrigins ?? [];
    }


    public function __invoke(Request $request, Response $response, callable $next)
    {
        /** @var Response $finalResponse */
        $finalResponse = $next($request,$response);

        $origins = count($this->allowedOrigins) == 0 ? "*" : implode(",",$this->allowedOrigins);

        return $finalResponse
            ->withHeader("Access-Control-Allow-Origin:",$origins)
            ->withHeader("Access-Control-Allow-Methods","POST, GET, OPTIONS, DELETE");
    }
}