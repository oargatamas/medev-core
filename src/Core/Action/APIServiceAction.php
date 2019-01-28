<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 16.
 * Time: 14:30
 */

namespace MedevSlim\Core\Action;


use MedevSlim\Core\Service\APIService;


/**
 * Class APIServiceAction
 * @package MedevSlim\Core\Action
 */
abstract class APIServiceAction
{
    /**
     * @var APIService
     */
    protected $service;


    /**
     * APIServiceAction constructor.
     * @param APIService $service
     */
    public function __construct(APIService $service)
    {
        $this->service = $service;
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