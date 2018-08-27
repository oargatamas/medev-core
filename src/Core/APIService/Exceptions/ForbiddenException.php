<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:08
 */

namespace MedevSuite\Core\APIService\Exceptions;


class ForbiddenException extends APIException
{
    public function __construct()
    {
        parent::__construct("Forbidden", 403);
    }

}