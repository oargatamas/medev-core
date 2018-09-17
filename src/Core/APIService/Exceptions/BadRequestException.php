<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 17.
 * Time: 8:27
 */

namespace MedevSlim\Core\APIService\Exceptions;


class BadRequestException extends APIException
{
    public function __construct()
    {
        parent::__construct("Bad Request", 400);
    }
}