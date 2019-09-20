<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 10. 04.
 * Time: 14:12
 */

namespace MedevSlim\Core\Action\Middleware;


use MedevSlim\Core\Action\RequestAttribute;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class RequestLogger
 * @package MedevSlim\Core\Action\Middleware
 */
class RequestLogger extends AppMiddleware
{


    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $uniqueId = $this->app->getRequestId();
        $channel = $this->app->getLogChannel();


        $inboundLogData = [
            RequestAttribute::INITIATOR => $request->getAttribute(RequestAttribute::IP_ADDRESS),
            RequestAttribute::METHOD => $request->getMethod(),
            RequestAttribute::URI => (string)$request->getUri(),
            RequestAttribute::REQUEST_PARAMS => json_encode($request->getParams()),
        ];


        $this->logger->info($channel, $uniqueId,"Inbound request data: ".implode(", ",$inboundLogData));

        /** @var Response $finalResponse */
        $finalResponse = $next($request->withAttribute(RequestAttribute::CORRELATION_ID, $uniqueId), $response);

        $outgoingLogData = [
            RequestAttribute::RESPONSE_DATA => $finalResponse->__toString()
        ];
        $this->logger->info($channel, $uniqueId,"Outbound response data: ". implode(", ",$outgoingLogData));

        return $finalResponse;
    }
}