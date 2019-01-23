<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 08.
 * Time: 15:38
 */

namespace MedevSlim\Core\APIService;


use MedevSlim\Core\APIAction\Middleware\RequestLogger;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use RKA\Middleware\IpAddress;
use Slim\App;
use Slim\Interfaces\RouteGroupInterface;

abstract class APIService
{

    /**
     * @var App
     */
    protected $application;
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var int
     */
    protected $logLevel;


    /**
     * APIService constructor.
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->application = $app;
        $this->logLevel = Logger::DEBUG;
    }

    /**
     * @param int $logLevel
     */
    public function setLogLevel($logLevel)
    {
        $this->logLevel = $logLevel;
    }

    /**
     * @return mixed
     */
    public abstract function getServiceName();


    /**
     * @param string $baseUrl
     * @throws \Exception
     */
    public function register($baseUrl = "/")
    {
        $service = $this;
        $app = $this->application;
        $container = $app->getContainer();

        $this->registerContainerComponents($container);
        
        $group = $app->group($baseUrl, function()use ($app,$container,$service){
            $service->registerRoutes($app,$container);
        });
        $this->registerMiddlewares($group,$container);

        $group->add(new RequestLogger($this->getLogger()));
        $group->add(new IpAddress());
    }

    /**
     * @param App $app
     * @param ContainerInterface $container
     * @return mixed
     */
    protected abstract function registerRoutes(App $app, ContainerInterface $container);

    /**
     * @param RouteGroupInterface $group
     * @param ContainerInterface $container
     */
    protected function registerMiddlewares(RouteGroupInterface $group, ContainerInterface $container){
        //Do nothing
    }

    /**
     * @param ContainerInterface $container
     */
    protected function registerContainerComponents(ContainerInterface $container){
        //Do nothing
    }

    /**
     * @return Logger
     * @throws \Exception
     */
    protected function getLogger(){
        $logger = new Logger('MedevSuiteAuthServer');

        $logger->pushHandler(new StreamHandler($_SERVER['DOCUMENT_ROOT']."/../log/".$this->getServiceName().".log",$this->logLevel));

        return $logger;
    }
}