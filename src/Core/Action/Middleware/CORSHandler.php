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
use Slim\Route;

class CORSHandler
{
    private $config;

    /**
     * CORSHandler constructor.
     * @param $accessControlConfig
     */
    public function __construct($accessControlConfig)
    {
        $this->config = $accessControlConfig;
    }


    public function __invoke(Request $request, Response $response, callable $next)
    {
        $routeInfo = $request->getAttribute("routeInfo");

        $allowedOrigins = $this->config["allowed_origins"];
        $allowedMethods = $routeInfo[1];
        $allowedHeaders = $this->config["allowed_headers"];


        if ($request->getMethod() === "OPTIONS") {
            return $response
                ->withStatus(204)
                ->withHeader("Access-Control-Allow-Origin:", implode(", ", $allowedOrigins))
                ->withHeader("Access-Control-Allow-Methods", implode(", ", $allowedMethods))
                ->withHeader("Access-Control-Allow-Headers", implode(", ", $allowedHeaders));
        }

        /** @var Response $finalResponse */
        $finalResponse = $next($request, $response);

        /** @var Route $route */
        $route = $request->getAttribute("route");
        $allowedMethods = $route->getMethods();

        return $finalResponse
            ->withHeader("Access-Control-Allow-Origin", implode(", ", $allowedOrigins))
            ->withHeader("Access-Control-Allow-Methods", implode(", ", $allowedMethods))
            ->withHeader("Access-Control-Allow-Headers", implode(", ", $allowedHeaders));
    }
}