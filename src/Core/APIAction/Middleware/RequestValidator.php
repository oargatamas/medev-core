<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 10. 01.
 * Time: 11:33
 */

namespace MedevSlim\Core\APIAction\Middleware;


use MedevSlim\Core\APIService\Exceptions\BadRequestException;
use Slim\Http\Request;
use Slim\Http\Response;

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


    public function __invoke(Request $request, Response $response, callable $next)
    {
        $requestBody = $request->getParsedBody();
        foreach ($this->requiredParams as $requiredParamName){
            if(!isset($requestBody[$requiredParamName])){
                throw new BadRequestException();
            }
        }

        return $next($request,$response);
    }
}