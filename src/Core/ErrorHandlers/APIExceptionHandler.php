<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 16.
 * Time: 15:22
 */

namespace MedevSlim\Core\ErrorHandlers;



use MedevSlim\Core\APIService\Exceptions\APIException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Handlers\Error;

class APIExceptionHandler extends Error
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, \Exception $exception)
    {
        $statusCode = 500;
        if($exception instanceof APIException){
            $statusCode = $exception->getHTTPStatus();
        }
        $message = $this->displayErrorDetails ? $this->renderJsonErrorMessage($exception) : $exception->getMessage();
        return $response
            ->withStatus($statusCode)
            ->withHeader("Content-type", "application/json")
            ->getBody()->write($message);
    }
}