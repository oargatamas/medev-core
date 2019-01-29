<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 01. 28.
 * Time: 16:01
 */

namespace MedevSlim\Core\Application;


use MedevSlim\Core\Action\Middleware\RequestLogger;
use MedevSlim\Core\ErrorHandlers\ErrorHandlers;
use MedevSlim\Core\Logging\LogContainer;
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
    const REQUEST_ID = "uniqueId";
    const LOG_CHANNEL = "logChannel";
    const REQUEST = "request";
    const RESPONSE = "response";
    const ROUTER = "router";


    /**
     * @var string
     */
    private $uniqueId;
    /**
     * @var string
     */
    private $channel;


    /**
     * MedevApp constructor.
     * @param array $container
     */
    public function __construct($container = [])
    {
        parent::__construct($container);
        $container = $this->getContainer();

        $instance = $this;

        $container[self::class] = function () use($instance){return $instance;};
        LogContainer::inject($container);
        ErrorHandlers::inject($container);

        $this->add(new RequestLogger($this));
        $this->add(new IpAddress());
    }


    /**
     * @param bool $silent
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Slim\Exception\MethodNotAllowedException
     * @throws \Slim\Exception\NotFoundException
     */
    public function run($silent = false)
    {
        $this->uniqueId = $this->generateRequestUniqueId();
        $this->channel = $this->findRequestChannel();
        return parent::run($silent);
    }


    /**
     * @return string
     */
    protected function generateRequestUniqueId(){
        return UUID::v4();
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

        $url = $request->getUri()->getPath();

        foreach ($router->getRoutes() as $route){
            if ($route->getPattern() === $url){
                return $route->getName();
            }
        }

        return LogContainer::DEFAULT_LOGGER_CHANNEL;
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
    public function getUniqueId()
    {
        return $this->uniqueId;
    }

    /**
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

}