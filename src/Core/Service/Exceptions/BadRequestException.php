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
     * BadRequestException constructor.
     * @param string $service
     * @param string $reason
     */
    public function __construct($service = "", $reason = "")
    {
        parent::__construct($service,"Bad Request", 400,$reason);
    }
}