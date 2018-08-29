<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:27
 */

namespace MedevSlim\Core\ErrorHandlers;


use Slim\Http\Request;
use Slim\Http\Response;

class PHPRuntimeHandler
{
    public function __invoke(Request $request, Response $response,\Exception $exception) {
        var_dump($exception);
        return $response
            ->withStatus(500)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode("Something went wrong:"));
    }
}