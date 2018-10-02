<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:27
 */

namespace MedevSlim\Core\ErrorHandlers;


use Monolog\Logger;
use Slim\Http\Request;
use Slim\Http\Response;

class PHPRuntimeHandler
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


    public function __invoke(Request $request, Response $response, $exception) {

        $this->logger->log(Logger::ERROR,"PHPRuntime Exception raised",[$request,$exception]);

        return $response
            ->withStatus(500)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode("Something went wrong."));
    }
}