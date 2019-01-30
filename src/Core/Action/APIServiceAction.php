<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 16.
 * Time: 14:30
 */

namespace MedevSlim\Core\Action;


use MedevSlim\Core\Logging\LogContainer;
use MedevSlim\Core\Logging\RequestInfo;
use MedevSlim\Core\Service\APIService;


/**
 * Class APIServiceAction
 * @package MedevSlim\Core\Action
 */
abstract class APIServiceAction
{
    use RequestInfo;
    /**
     * @var APIService
     */
    protected $service;


    /**
     * @var LogContainer
     */
    protected $logger;


    /**
     * APIServiceAction constructor.
     * @param APIService $service
     * @throws \Exception
     */
    public function __construct(APIService $service)
    {
        $this->service = $service;
        $this->logger = $service->getLogger();
        $this->requestId = $service->getRequestId();
        $this->logChannel = $service->getLogChannel();
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