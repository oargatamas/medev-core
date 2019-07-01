<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 07. 01.
 * Time: 14:08
 */

namespace MedevSlim\Core\Service\Exceptions;


class InternalServerException extends APIException
{
    /**
     * @inheritDoc
     */
    public function __construct($reason = "", $replicateReasonAsMessage = false)
    {
        parent::__construct("Internal Server Error", 500, $reason, $replicateReasonAsMessage);
    }


}