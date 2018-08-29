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
        $contentType = $this->determineContentType($request);

        if($exception instanceof APIException){
            $response->withStatus($exception->getHTTPStatus());
            $response->withHeader('Content-type', $contentType);
            $response->getBody()->write($exception->getMessage());

            return $response;

        }else{
            return parent::__invoke($request,$response,$exception);
        }
    }
}