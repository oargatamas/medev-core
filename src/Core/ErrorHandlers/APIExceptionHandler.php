<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 16.
 * Time: 15:22
 */

namespace MedevSlim\Core\ErrorHandlers;



use MedevSlim\Core\Action\Middleware\CORSHandler;
use MedevSlim\Core\Application\MedevApp;
use MedevSlim\Core\DependencyInjection\DependencyInjector;
use MedevSlim\Core\Logging\LogContainer;
use MedevSlim\Core\Service\Exceptions\APIException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Handlers\Error;

/**
 * Class APIExceptionHandler
 * @package MedevSlim\Core\ErrorHandlers
 */
class APIExceptionHandler extends Error implements DependencyInjector
{
    /**
     * @var LogContainer
     */
    private $logger;


    /**
     * @var MedevApp
     */
    private $app;

    /**
     * @var array
     */
    private $corsConfig;

    /**
     * PHPRuntimeHandler constructor.
     * @param ContainerInterface $container
     * @param boolean $displayErrorDetails
     */
    public function __construct(ContainerInterface $container,$displayErrorDetails)
    {
        $this->app = $container->get(MedevApp::class);
        $this->logger = $container->get(LogContainer::class);
        $this->corsConfig = $this->app->getConfiguration()["cors"];
        parent::__construct($displayErrorDetails);
    }


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param \Exception $exception
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, \Exception $exception)
    {
        $uniqueId = $this->app->getRequestId();
        $channel = $this->app->getLogChannel();


        $this->logger->error($channel,$uniqueId,"Exception during request: ".$exception->__toString()."\n StackTrace: ".$exception->getTraceAsString());

        $message = "Internal Server Error";
        $statusCode = 500;
        if($exception instanceof APIException){
            $statusCode = $exception->getHTTPStatus();
            $message = $exception->getMessage();
        }

        $response->getBody()->write(json_encode($message));


        $allowedOrigins = $this->corsConfig["allowed_origins"];
        $allowedMethods = CORSHandler::getAllowedMethods($request);
        $allowedHeaders = $this->corsConfig["allowed_headers"];


        return $this->app->mapResponseWithCORS($response, $allowedOrigins, $allowedMethods, $allowedHeaders)
            ->withStatus($statusCode)
            ->withHeader("Content-type", "application/json");
    }

    /**
     * @param ContainerInterface $container
     */
    static function inject(ContainerInterface $container)
    {
        $container["errorHandler"] = function (ContainerInterface $container){
            return new APIExceptionHandler($container,$container->get('settings')['displayErrorDetails']);
        };
    }
}