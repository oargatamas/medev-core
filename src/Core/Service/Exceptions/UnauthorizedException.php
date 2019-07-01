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
     * @inheritDoc
     */
    public function __construct( $reason = "", $replicateReasonAsMessage = false)
    {
        parent::__construct("Unauthorized", 401,$reason, $replicateReasonAsMessage);
    }

}