<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:31
 */

namespace MedevSlim\Core\ErrorHandlers;


use Monolog\Logger;
use Slim\Http\Request;
use Slim\Http\Response;

class NotAllowedHandler
{

    /**
     * @var Logger
     */
    private $logger;

    /**
     * PHPRuntimeHandler constructor.
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(Request $request,Response $response, $methods) {
        $this->logger->log(Logger::ERROR,"Method not allowed", [$methods]);

        return $response
            ->withStatus(405)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode("Method not allowed"));
    }
}