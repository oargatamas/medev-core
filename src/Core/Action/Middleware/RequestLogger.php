<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 10. 04.
 * Time: 14:12
 */

namespace MedevSlim\Core\Action\Middleware;


use MedevSlim\Utils\UUID\UUID;
use Monolog\Logger;
use Slim\Http\Request;
use Slim\Http\Response;

class RequestLogger
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * RequestLogger constructor.
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }


    public function __invoke(Request $request,Response $response,callable $next)
    {
        //Todo move labels to constants
        $uniqueId = UUID::v4();
        $inboundLogData = [
            "CorrelationId" => $uniqueId,
            "Initiator" => $request->getAttribute("ip_address"),
            "URI" => $request->getUri(),
            "Method" => $request->getMethod(),
            "Params" => $request->getParams()
        ];

        $this->logger->log(Logger::INFO,"Inbound request data",$inboundLogData);


        /** @var Response $finalResponse */
        $finalResponse = $next($request->withAttribute("CorrelationId", $uniqueId), $response);

        $outgoingLogData = [
            "CorrelationId" => $uniqueId,
            "ResponseData" => $finalResponse->__toString()
        ];
        $this->logger->log(Logger::INFO,"Outbound response data",$outgoingLogData);

        return $finalResponse;
    }
}