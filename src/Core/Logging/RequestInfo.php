<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 01. 30.
 * Time: 10:40
 */

namespace MedevSlim\Core\Logging;


/**
 * Trait RequestInfo
 * @package MedevSlim\Core\Logging
 */
trait RequestInfo
{
    /**
     * @var
     */
    protected $requestId;
    /**
     * @var
     */
    protected $logChannel;

    /**
     * @return string
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @return string
     */
    public function getLogChannel()
    {
        return $this->logChannel;
    }


}