<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 08. 05.
 * Time: 7:53
 */

namespace MedevSlim\Core\Action\Middleware;


use FastRoute\Dispatcher;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Route;

class CORSHandler extends AppMiddleware
{


    public function __invoke(Request $request, Response $response, callable $next)
    {
        $corsConfig = $this->config["cors"];

        $allowedOrigins = $corsConfig["allowed_origins"];
        $allowedMethods = self::getAllowedMethods($request);
        $allowedHeaders = $corsConfig["allowed_headers"];


        if ($request->getMethod() === "OPTIONS") {
            return $this->app->mapResponseWithCORS($response, $allowedOrigins, $allowedMethods, $allowedHeaders)
                ->withStatus(204);
        }

        /** @var Response $finalResponse */
        $finalResponse = $next($request, $response);

        return $this->app->mapResponseWithCORS($finalResponse, $allowedOrigins, $allowedMethods, $allowedHeaders);
    }

    public static function getAllowedMethods(ServerRequestInterface $request)
    {
        $routeInfo = $request->getAttribute("routeInfo");
        /** @var Route $route */
        $route = $request->getAttribute("route");

        switch ($routeInfo[0]) {
            case Dispatcher::FOUND:
                return $route->getMethods();
            case Dispatcher::METHOD_NOT_ALLOWED:
                return $routeInfo[1];
            default :
                return [];
        }
    }
}