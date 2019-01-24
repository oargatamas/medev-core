<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 01. 24.
 * Time: 14:40
 */

namespace MedevSlim\Core\Action\Repository;


use MedevSlim\Core\Action\APIServiceAction;
use MedevSlim\Core\Service\APIService;
use Medoo\Medoo;

/**
 * Class APIRepositoryAction
 * @package MedevSlim\Core\Action\Repository
 */
abstract class APIRepositoryAction extends APIServiceAction
{
    /**
     * @var Medoo
     */
    protected $database;

    /**
     * APIRepositoryAction constructor.
     * @param APIService $service
     * @param Medoo $database
     */
    public function __construct(APIService $service, Medoo $database)
    {
        parent::__construct($service);
        $this->database= $database;
    }

    /**
     * @param $args
     * @return mixed
     */
    public abstract function handleRequest($args);
}