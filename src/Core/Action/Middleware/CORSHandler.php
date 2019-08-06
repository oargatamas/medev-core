<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 08. 05.
 * Time: 7:53
 */

namespace MedevSlim\Core\Action\Middleware;


use MedevSlim\Core\Application\MedevApp;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Route;

class CORSHandler
{
    private $app;
    private $config;

    /**
     * CORSHandler constructor.
     * @param MedevApp $app
     */
    public function __construct(MedevApp $app)
    {
        $this->app = $app;
        $this->config = $app->getConfiguration()["cors"];
    }


    public function __invoke(Request $request, Response $response, callable $next)
    {
        $routeInfo = $request->getAttribute("routeInfo");

        $allowedOrigins = $this->config["allowed_origins"];
        $allowedMethods = $routeInfo[1];
        $allowedHeaders = $this->config["allowed_headers"];


        if ($request->getMethod() === "OPTIONS") {
            return $this->app->mapResponseWithCORS($response,$allowedOrigins,$allowedMethods,$allowedHeaders)
                ->withStatus(204);
        }

        /** @var Response $finalResponse */
        $finalResponse = $next($request, $response);

        /** @var Route $route */
        $route = $request->getAttribute("route");
        $allowedMethods = $route->getMethods();

        return $this->app->mapResponseWithCORS($finalResponse,$allowedOrigins,$allowedMethods,$allowedHeaders);
    }
}