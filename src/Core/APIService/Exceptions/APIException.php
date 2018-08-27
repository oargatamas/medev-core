<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:10
 */

namespace MedevSuite\Core\APIService\Exceptions;



class APIException extends \Exception
{

    protected $httpStatusCode;

    public function __construct($message = "", $httpStatusCode = 500)
    {
        $this->httpStatusCode = $httpStatusCode;
        parent::__construct($message, 0, null);
    }

    public function getHTTPStatus()
    {
        return $this->httpStatusCode;
    }
}