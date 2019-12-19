<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 01. 26.
 * Time: 16:38
 */

namespace MedevSlim\Core\Action;


class RequestAttribute
{
    const IP_ADDRESS = "ip_address";
    const SCOPES = "Scopes";
    const CORRELATION_ID = "CorrelationId";
    const INITIATOR = "Initiator";
    const URI = "URI";
    const METHOD = "Method";
    const REQUEST_PARAMS = "Params";
    const RESPONSE_HEADERS = "ResponseHeaders";
    const RESPONSE_BODY = "ResponseBody";
}