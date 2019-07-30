<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 01. 28.
 * Time: 16:01
 */

namespace MedevSlim\Core\Application;


use FastRoute\Dispatcher;
use MedevSlim\Core\Action\Middleware\RequestLogger;
use MedevSlim\Core\Database\Medoo\MedooDatabase;
use MedevSlim\Core\ErrorHandlers\ErrorHandlers;
use MedevSlim\Core\Logging\LogContainer;
use MedevSlim\Core\Logging\RequestInfo;
use MedevSlim\Core\Service\APIService;
use MedevSlim\Utils\UUID\UUID;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use RKA\Middleware\IpAddress;
use Slim\App;
use Slim\Router;

/**
 * Class MedevApp
 * @package MedevSlim\Core\Application
 */
class MedevApp extends App
{
    use RequestInfo;

    const REQUEST_ID = "uniqueId";
    const LOG_CHANNEL = "logChannel";
    const REQUEST = "request";
    const RESPONSE = "response";
    const ROUTER = "router";


    /**
     * @param string $pathToConfig
     * @return MedevApp
     */
    public static function fromJsonFile($pathToConfig){
        $configJson = file_get_contents($pathToConfig);
        $config = json_decode($configJson,true);
        return new MedevApp($config);
    }

    /**
     * MedevApp constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct(["settings" => $config]);
        $container = $this->getContainer();

        $instance = $this;

        $container[self::class] = function () use($instance){return $instance;};
        LogContainer::inject($container);
        ErrorHandlers::inject($container);

        if(isset($config["database"])){
            MedooDatabase::inject($container);
        }

        $this->add(new RequestLogger($this));
        $this->add(new IpAddress());

        $this->requestId = $this->generateRequestUniqueId();
    }



    /**
     * @param bool $silent
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Slim\Exception\MethodNotAllowedException
     * @throws \Slim\Exception\NotFoundException
     */
    public function run($silent = false)
    {
        $this->logChannel = $this->findRequestChannel();
        return parent::run($silent);
    }


    /**
     * @return string
     */
    protected function generateRequestUniqueId(){
        return UUID::v4();
    }


    /**
     * @return array
     */
    public function getConfiguration(){
        return $this->getContainer()->get("settings");
    }

    /**
     * @return string
     */
    protected function findRequestChannel(){
        /** @var ContainerInterface $container */
        $container = $this->getContainer();
        /** @var ServerRequestInterface $request */
        $request = $container->get(self::REQUEST);
        /** @var Router $router */
        $router = $container->get(self::ROUTER);

        $routeInfo = $router->dispatch($request);

        if($routeInfo[0] === Dispatcher::NOT_FOUND){
            return LogContainer::DEFAULT_LOGGER_CHANNEL;
        }

        $route = $router->lookupRoute($routeInfo[1]);

        return $route->getArgument(APIService::SERVICE_ID,LogContainer::DEFAULT_LOGGER_CHANNEL);
    }

    /**
     * @param string $baseUrl
     * @param APIService $service
     * @throws \Exception
     */
    public function addAPIService($baseUrl, APIService $service){
        $service->registerService($baseUrl);
    }

    /**
     * @return LogContainer
     */
    public function getLogContainer(){
        return $this->getContainer()->get(LogContainer::class);
    }

    /**
     * @return string
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @return string
     */
    public function getLogChannel()
    {
        return $this->logChannel;
    }

}