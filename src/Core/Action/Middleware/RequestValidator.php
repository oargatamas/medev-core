<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 10. 01.
 * Time: 11:33
 */

namespace MedevSlim\Core\Action\Middleware;


use MedevSlim\Core\Service\Exceptions\BadRequestException;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class RequestValidator
 * @package MedevSlim\Core\Action\Middleware
 */
class RequestValidator
{


    /**
     * @var string[]
     */
    private $requiredParams;

    /**
     * RequestValidator constructor.
     * @param string[] $requiredParams
     */
    public function __construct(array $requiredParams)
    {
        $this->requiredParams = $requiredParams;
    }


    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     * @throws BadRequestException
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $requestBody = $request->getParsedBody();
        foreach ($this->requiredParams as $requiredParamName){
            if(!isset($requestBody[$requiredParamName])){ //Todo check whether the isset() is enough or not
                throw new BadRequestException("Paramater not set in request: " . $requiredParamName);
            }
        }


        $sanitizedBody = [];
        foreach ($requestBody as $key => $requestBodyParam){
            $sanitizedBody[$key] = filter_var($requestBodyParam, FILTER_SANITIZE_STRING);
        }

        $sanitizedQuery = [];
        foreach ($request->getQueryParams() as $key => $requestQueryParam){
            $sanitizedQuery[$key] = filter_var($requestQueryParam, FILTER_SANITIZE_STRING);
        }

        $sanitizedRequest = $request->withParsedBody($sanitizedBody)->withQueryParams($sanitizedQuery);

        return $next($sanitizedRequest,$response);
    }
}