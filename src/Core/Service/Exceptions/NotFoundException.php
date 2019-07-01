<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 11.
 * Time: 14:19
 */

namespace MedevSlim\Core\Service\Exceptions;

/**
 * Class NotFoundException
 * @package MedevSlim\Core\Service\Exceptions
 */
class NotFoundException extends APIException
{
    /**
     * @inheritDoc
     */
    public function __construct($reason = "", $replicateReasonAsMessage = false)
    {
        parent::__construct("Resource Not Found", 404,$reason, $replicateReasonAsMessage);
    }
}