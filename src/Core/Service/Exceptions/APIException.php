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
abstract class APIException extends \Exception
{

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
     * @param string $message
     * @param int $httpStatusCode
     * @param string $reason
     * @param bool $replicateReasonAsMessage
     */
    public function __construct($message = "", $httpStatusCode = 500, $reason = "", $replicateReasonAsMessage = false)
    {
        $this->httpStatusCode = $httpStatusCode;
        $this->reasonPhrase = $reason;
        parent::__construct($replicateReasonAsMessage ? $reason : $message, 0, null);
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
    public function __toString()
    {
        return  $this->getMessage(). " (".$this->httpStatusCode.") - " . $this->reasonPhrase;
    }


}