<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 10. 04.
 * Time: 14:12
 */

namespace MedevSlim\Core\Action\Middleware;


use MedevSlim\Core\Action\RequestAttribute;
use MedevSlim\Core\Application\MedevApp;
use MedevSlim\Core\Logging\LogContainer;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class RequestLogger
 * @package MedevSlim\Core\Action\Middleware
 */
class RequestLogger
{

    /**
     * @var MedevApp
     */
    private $app;

    /**
     * @var LogContainer
     */
    private $logger;


    /**
     * RequestLogger constructor.
     * @param MedevApp $app
     */
    public function __construct(MedevApp $app)
    {
        $this->app = $app;
        $this->logger = $app->getLogContainer();
    }


    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $uniqueId = $this->app->getUniqueId();
        $channel = $this->app->getChannel();


        $inboundLogData = [
            RequestAttribute::INITIATOR => $request->getAttribute(RequestAttribute::IP_ADDRESS),
            RequestAttribute::URI => (string)$request->getUri(),
            RequestAttribute::METHOD => $request->getMethod(),
            RequestAttribute::REQUEST_PARAMS => $request->getParams(),
        ];


        $this->logger->info($channel, $uniqueId,"Inbound request data: ",$inboundLogData);

        $attributes = [
            RequestAttribute::CORRELATION_ID => $uniqueId
        ];

        /** @var Response $finalResponse */
        $finalResponse = $next($request->withAttributes($attributes), $response);

        $outgoingLogData = [
            RequestAttribute::RESPONSE_DATA => $finalResponse->__toString()
        ];
        $this->logger->info($channel, $uniqueId,"Outbound response data: ",$outgoingLogData);

        return $finalResponse;
    }
}