<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 12.
 * Time: 17:43
 */

namespace MedevSlimExample\Services\Dummy\Actions;


use MedevSlim\Core\Action\Servlet\APIServletAction;
use Slim\Http\Request;
use Slim\Http\Response;

class DummyHTTPAction extends APIServletAction
{

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     * @throws \Exception
     */
    public function handleRequest(Request $request, Response $response, $args)
    {

        //examples for logging:
        $this->debug("Debug message");
        $this->info("Info message");
        $this->warn("Warning message");
        $this->error("Error message");


        $data = (new DummyRepositoryAction($this->service))->handleRequest($args);

        return $response->withJson($data,200); //maybe some options needed for the json encode.
    }
}