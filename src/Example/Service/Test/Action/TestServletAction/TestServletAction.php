<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 01. 28.
 * Time: 12:39
 */

namespace MedevSlim\Example\Service\Test\Action\TestServletAction;


use MedevSlim\Core\Action\Servlet\APIServletAction;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class TestServletAction
 * @package MedevSlim\Example\Service\Test\Action\TestServletAction
 * {@inheritdoc}
 */
class TestServletAction extends APIServletAction
{

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    public function handleRequest(Request $request, Response $response, $args)
    {
        return $response->withJson(["scopes" => TestServletAction::getScopes(), "params" => TestServletAction::getParams()]);
    }

    static function getParams()
    {
        return ["kiskutya"];
    }


}