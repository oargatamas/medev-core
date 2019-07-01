<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 17.
 * Time: 8:27
 */

namespace MedevSlim\Core\Service\Exceptions;


/**
 * Class BadRequestException
 * @package MedevSlim\Core\Service\Exceptions
 */
class BadRequestException extends APIException
{
    /**
     * @inheritDoc
     */
    public function __construct($reason = "", $replicateReasonAsMessage = false)
    {
        parent::__construct("Bad Request", 400,$reason, $replicateReasonAsMessage);
    }

    public function __toString()
    {
        return parent::__toString();
    }


}