<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 10. 04.
 * Time: 14:12
 */

namespace MedevSlim\Core\Action\Middleware;


use MedevSlim\Core\Action\RequestAttribute;
use MedevSlim\Core\Service\APIService;
use MedevSlim\Utils\UUID\UUID;
use Monolog\Logger;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class RequestLogger
 * @package MedevSlim\Core\Action\Middleware
 */
class RequestLogger
{
    /**
     * @var APIService
     */
    private $service;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * RequestLogger constructor.
     * @param APIService $service
     * @throws \Exception
     */
    public function __construct(APIService $service)
    {
        $this->service = $service;
        $this->logger = $service->getLogger();
    }


    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        //Todo move labels to constants
        $uniqueId = UUID::v4();
        $inboundLogData = [
            RequestAttribute::CORRELATION_ID => $uniqueId,
            RequestAttribute::INITIATOR => $request->getAttribute(RequestAttribute::IP_ADDRESS),
            RequestAttribute::URI => $request->getUri(),
            RequestAttribute::METHOD => $request->getMethod(),
            RequestAttribute::REQUEST_PARAMS => $request->getParams()
        ];

        $this->logger->info("Inbound request data: ",$inboundLogData);


        $attributes = [
            RequestAttribute::HANDLER_SERVICE => $this->service->getServiceName(),
            RequestAttribute::CORRELATION_ID => $uniqueId,
        ];

        /** @var Response $finalResponse */
        $finalResponse = $next($request->withAttributes($attributes), $response);

        $outgoingLogData = [
            RequestAttribute::CORRELATION_ID => $uniqueId,
            RequestAttribute::RESPONSE_DATA => $finalResponse->__toString()
        ];
        $this->logger->info("Outbound response data: ",$outgoingLogData);

        return $finalResponse;
    }
}