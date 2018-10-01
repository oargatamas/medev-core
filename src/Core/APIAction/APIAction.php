<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 16.
 * Time: 14:30
 */

namespace MedevSlim\Core\APIAction;


use MedevSlim\Core\APIService\Exceptions\UnauthorizedException;
use Psr\Container\ContainerInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class APIAction
{
    protected $container;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        return $this->onPermissionGranted($request, $response, $args);
    }

    /**
     * @return string[]
     */
    public static function getPermissions(){
        return [];
    }

    /**
     * @return string[]
     */
    public static function getRequiredRequestParams(){
        return [];
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    protected abstract function onPermissionGranted(Request $request, Response $response, $args);
}