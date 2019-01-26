<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 16.
 * Time: 15:22
 */

namespace MedevSlim\Core\ErrorHandlers;



use MedevSlim\Core\Action\RequestAttribute;
use MedevSlim\Core\Logging\LogContainer;
use MedevSlim\Core\Service\Exceptions\APIException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Handlers\Error;

class APIExceptionHandler extends Error
{
    /**
     * @var LogContainer
     */
    private $logContainer;

    /**
     * PHPRuntimeHandler constructor.
     * @param ContainerInterface $container
     * @param boolean $displayErrorDetails
     */
    public function __construct(ContainerInterface $container,$displayErrorDetails)
    {
        $this->logContainer = $container->get(LogContainer::class);
        parent::__construct($displayErrorDetails);
    }


    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, \Exception $exception)
    {
        $this->logContainer->error($request->getAttribute(RequestAttribute::HANDLER_SERVICE),"APIException raised", [$exception->__toString()]);

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