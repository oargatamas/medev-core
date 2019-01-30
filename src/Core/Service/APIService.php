<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 08.
 * Time: 15:38
 */

namespace MedevSlim\Core\Service;


use MedevSlim\Core\Application\MedevApp;
use MedevSlim\Core\Logging\LogContainer;
use MedevSlim\Core\Logging\RequestInfo;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Interfaces\RouteGroupInterface;

/**
 * Class APIService
 * @package MedevSlim\Core\Service
 */
abstract class APIService
{
    use RequestInfo;
    /**
     * @var MedevApp
     */
    protected $application;
    /**
     * @var LogContainer
     */
    protected $logger;

    /**
     * @var int
     */
    protected $logLevel;



    /**
     * APIService constructor.
     * @param MedevApp $app
     * @throws \Exception
     */
    public function __construct(MedevApp $app)
    {
        $this->application = $app;
        $this->requestId = $app->getRequestId();
        $this->logChannel = $app->getLogChannel();
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
     * @return LogContainer
     * @throws \Exception
     */
    public function getLogger()
    {
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

        $group = $app->group($baseUrl, function () use ($app, $service) {
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
     * @throws \Exception
     */
    protected function registerMiddlewares(RouteGroupInterface $group)
    {
        //Do nothing. Override it to add middlewares to the group
    }


    /**
     * @param ContainerInterface $container
     * @throws \Exception
     */
    protected function registerContainerComponents(ContainerInterface $container)
    {
        $this->logger = $container->get(LogContainer::class);

        $logger = new Logger($this->getServiceName());
        $handler = new StreamHandler($_SERVER['DOCUMENT_ROOT'] . "/../log/" . $this->getServiceName() . ".log", $this->logLevel);
        $formatter = new LineFormatter(LogContainer::LOG_FILE_FORMAT);
        $handler->setFormatter($formatter);
        $logger->pushHandler($handler);

        $this->logger->addLogger($logger);
    }
}