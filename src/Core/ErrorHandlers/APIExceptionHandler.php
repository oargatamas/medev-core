<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 16.
 * Time: 15:22
 */

namespace MedevSlim\Core\ErrorHandlers;



use MedevSlim\Core\APIService\Exceptions\APIException;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Handlers\Error;

class APIExceptionHandler extends Error
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * PHPRuntimeHandler constructor.
     * @param boolean $displayErrorDetails
     * @param Logger $logger
     */
    public function __construct($displayErrorDetails,Logger $logger)
    {
        $this->logger = $logger;
        parent::__construct($displayErrorDetails);
    }


    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, \Exception $exception)
    {
        $this->logger->log(Logger::ERROR,"APIException raised", [$exception->__toString()]);

        $statusCode = 500;
        if($exception instanceof APIException){

            $statusCode = $exception->getHTTPStatus();
        }

        $response->getBody()->write($this->renderJsonErrorMessage($exception));

        return $response
            ->withStatus($statusCode)
            ->withHeader("Content-type", "application/json");
    }
}