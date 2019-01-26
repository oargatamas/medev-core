<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:08
 */

namespace MedevSlim\Core\Service\Exceptions;


/**
 * Class ForbiddenException
 * @package MedevSlim\Core\Service\Exceptions
 */
class ForbiddenException extends APIException
{
    /**
     * ForbiddenException constructor.
     * @param string $service
     * @param string $reason
     */
    public function __construct($service = "", $reason = "")
    {
        parent::__construct($service,"Forbidden", 403,$reason);
    }

}