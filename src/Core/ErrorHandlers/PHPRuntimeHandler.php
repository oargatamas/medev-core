<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:27
 */

namespace MedevSuite\Core\ErrorHandlers;


class PHPRuntimeHandler
{
    public function __invoke($request, $response, $exception) {
        var_dump($exception);
        return $response
            ->withStatus(500)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode("Something went wrong:"));
    }
}