<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 08.
 * Time: 15:38
 */

namespace MedevSlim\Core\Service;


use MedevSlim\Core\Action\Middleware\RequestLogger;
use MedevSlim\Core\Logging\LogContainer;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use RKA\Middleware\IpAddress;
use Slim\App;
use Slim\Interfaces\RouteGroupInterface;

/**
 * Class APIService
 * @package MedevSlim\Core\Service
 */
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
     * @return ContainerInterface
     */
    public function getServiceContainer(){
        return $this->application->getContainer();
    }


    /**
     * @param string $component
     * @return mixed
     */
    public function getServiceContainerComponent($component){
        return $this->application->getContainer()->get($component);
    }

    /**
     * @return Logger
     * @throws \Exception
     */
    public function getLogger()
    {
        if(is_null($this->logger)){
            $this->logger = new Logger($this->getServiceName());
            $this->logger->pushHandler(new StreamHandler($_SERVER['DOCUMENT_ROOT'] . "/../log/" . $this->getServiceName() . ".log", $this->logLevel));
        }

        return $this->logger;
    }

    /**
     * @param Logger $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param string $baseUrl
     * @throws \Exception
     */
    public function registerService($baseUrl = "/")
    {
        $service = $this;
        $app = $this->application;
        $container = $app->getContainer();

        $this->registerContainerComponents($container);

        $group = $app->group($baseUrl, function()use ($app,$service){
            $service->registerRoutes($app); //Itt a "this" nem az APIService hanem ahol meghívódik a függvény
        });
        $this->registerMiddlewares($group);
    }

    /**
     * @param App $app
     */
    protected abstract function registerRoutes(App $app);

    /**
     * @param RouteGroupInterface $group
     */
    protected function registerMiddlewares(RouteGroupInterface $group){
        $group->add(new RequestLogger($this->logger));
        $group->add(new IpAddress());
    }


    /**
     * @param ContainerInterface $container
     * @throws \Exception
     */
    protected function registerContainerComponents(ContainerInterface $container){
        /** @var LogContainer $logContainer */
        $logContainer = $container->get(LogContainer::class);
        $logContainer->addLogger($this->getLogger());
    }

}