<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:08
 */

namespace MedevSlim\Core\APIService\Exceptions;


class ForbiddenException extends APIException
{
    public function __construct($reason = "")
    {
        parent::__construct("Forbidden", 403,$reason);
    }

}