<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:30
 */

namespace MedevSlim\Core\ErrorHandlers;


use Monolog\Logger;
use Slim\Http\Request;
use Slim\Http\Response;

class NotFoundHandler
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

    public function __invoke(Request $request,Response $response) {

        $this->logger->log(Logger::ERROR,"Route not found", [$request]);

        return $response
            ->withStatus(404)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode("Content not found"));
    }
}