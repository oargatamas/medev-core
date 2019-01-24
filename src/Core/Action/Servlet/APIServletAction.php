<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 01. 24.
 * Time: 14:39
 */

namespace MedevSlim\Core\Action\Servlet;


use MedevSlim\Core\Action\APIServiceAction;
use MedevSlim\Core\Service\APIService;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class APIServletAction
 * @package MedevSlim\Core\Action\Servlet
 */
abstract class APIServletAction extends APIServiceAction
{
    /**
     * APIServletAction constructor.
     * @param APIService $service
     */
    public function __construct(APIService $service)
    {
        parent::__construct($service);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    public abstract function handleRequest(Request $request, Response $response, $args);
}