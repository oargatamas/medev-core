<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:10
 */

namespace MedevSlim\Core\Service\Exceptions;


/**
 * Class APIException
 * @package MedevSlim\Core\Service\Exceptions
 */
class APIException extends \Exception
{

    /**
     * @var string
     */
    protected $service;

    /**
     * @var int
     */
    protected $httpStatusCode;

    /**
     * @var string
     */
    protected $reasonPhrase;

    /**
     * APIException constructor.
     * @param string $service
     * @param string $message
     * @param int $httpStatusCode
     * @param string $reason
     */
    public function __construct($service = "", $message = "", $httpStatusCode = 500, $reason = "")
    {
        $this->service = $service;
        $this->httpStatusCode = $httpStatusCode;
        $this->reasonPhrase = $reason;
        parent::__construct($message, 0, null);
    }

    /**
     * @return int
     */
    public function getHTTPStatus()
    {
        return $this->httpStatusCode;
    }

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return get_class($this) . " - " .$this->getMessage(). " (".$this->httpStatusCode.") - " . $this->reasonPhrase;
    }


}