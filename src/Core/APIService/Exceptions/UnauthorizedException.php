<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:04
 */

namespace MedevSlim\Core\APIService\Exceptions;


class UnauthorizedException extends APIException
{
    public function __construct($reason = "")
    {
        parent::__construct("Unauthorized", 401,$reason);
    }

}