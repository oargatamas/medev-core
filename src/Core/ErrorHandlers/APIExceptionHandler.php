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

        $response->getBody()->write($this->renderJsonErrorMessage($exception));

        return $response
            ->withStatus($statusCode)
            ->withHeader("Content-type", "application/json");
    }

    protected function renderJsonErrorMessage(\Exception $exception)
    {
        $error = [
            'message' => $exception->getMessage(), //Ezért a vacakért kellett felülírni az ősosztály metódusát...
        ];

        if ($this->displayErrorDetails) {
            $error['exception'] = [];

            do {
                $error['exception'][] = [
                    'type' => get_class($exception),
                    'code' => $exception->getCode(),
                    'message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => explode("\n", $exception->getTraceAsString()),
                ];
            } while ($exception = $exception->getPrevious());
        }

        return json_encode($error, JSON_PRETTY_PRINT);
    }


}