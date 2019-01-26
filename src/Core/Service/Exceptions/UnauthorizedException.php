<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:04
 */

namespace MedevSlim\Core\Service\Exceptions;


/**
 * Class UnauthorizedException
 * @package MedevSlim\Core\Service\Exceptions
 */
class UnauthorizedException extends APIException
{
    /**
     * UnauthorizedException constructor.
     * @param string $service
     * @param string $reason
     */
    public function __construct($service = "", $reason = "")
    {
        parent::__construct($service,"Unauthorized", 401,$reason);
    }

}