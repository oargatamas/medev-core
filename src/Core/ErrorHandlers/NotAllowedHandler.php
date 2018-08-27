<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:31
 */

namespace MedevSuite\Core\ErrorHandlers;


class NotAllowedHandler
{
    public function __invoke($request, $response, $methods) {
        return $response
            ->withStatus(405)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode("Method not allowed"));
    }
}