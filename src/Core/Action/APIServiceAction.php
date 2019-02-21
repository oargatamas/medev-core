<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 16.
 * Time: 14:30
 */

namespace MedevSlim\Core\Action;


use MedevSlim\Core\Logging\ComponentLogger;
use MedevSlim\Core\Service\APIService;


/**
 * Class APIServiceAction
 * @package MedevSlim\Core\Action
 */
abstract class APIServiceAction implements ComponentLogger
{
    const ACTION_NAME = "action";
    /**
     * @var string
     */
    protected $actionName;
    /**
     * @var APIService
     */
    protected $service;

    /**
     * @var array
     */
    protected $config;

    /**
     * APIServiceAction constructor.
     * @param APIService $service
     * @throws \Exception
     */
    public function __construct(APIService $service)
    {
        $this->service = $service;
        $this->actionName = substr(strrchr(get_called_class(), '\\'), 1);
        $this->config = $service->getConfiguration();
    }

    /**
     * @inheritDoc
     */
    public function debug($message, $args = [])
    {
        $args[self::ACTION_NAME] = $this->actionName;
        $this->service->debug($message,$args);
    }

    /**
     * @inheritDoc
     */
    public function info($message, $args = [])
    {
        $args[self::ACTION_NAME] = $this->actionName;
        $this->service->info($message,$args);
    }

    /**
     * @inheritDoc
     */
    public function warn($message, $args = [])
    {
        $args[self::ACTION_NAME] = $this->actionName;
        $this->service->warn($message,$args);
    }

    /**
     * @inheritDoc
     */
    public function error($message, $args = [])
    {
        $args[self::ACTION_NAME] = $this->actionName;
        $this->service->error($message,$args);
    }


    /**
     * @return string[]
     */
    static function getScopes(){
        return [];
    }

    /**
     * @return string[]
     */
    static function getParams(){
        return [];
    }
}