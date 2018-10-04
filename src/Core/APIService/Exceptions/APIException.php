<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:10
 */

namespace MedevSlim\Core\APIService\Exceptions;



class APIException extends \Exception
{

    protected $httpStatusCode;
    protected $reasonPhrase;

    public function __construct($message = "", $httpStatusCode = 500,$reason = "")
    {
        $this->httpStatusCode = $httpStatusCode;
        $this->reasonPhrase = $reason;
        parent::__construct($message, 0, null);
    }

    public function getHTTPStatus()
    {
        return $this->httpStatusCode;
    }

    public function __toString()
    {
        return get_class($this) . " - " .$this->getMessage(). "(".$this->httpStatusCode.") - " . $this->reasonPhrase;
    }


}