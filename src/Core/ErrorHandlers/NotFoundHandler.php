<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:30
 */

namespace MedevSuite\Core\ErrorHandlers;


class NotFoundHandler
{
    public function __invoke($request, $response) {
        return $response
            ->withStatus(404)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode("Content not found"));
    }
}