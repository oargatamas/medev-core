<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 09. 20.
 * Time: 14:50
 */

namespace MedevSlim\Core\Action\Middleware;


use Curl\Curl;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;
use Slim\Http\Request;
use Slim\Http\Response;

class ReCaptchaValidator extends AppMiddleware
{

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     * @throws \ErrorException
     * @throws UnauthorizedException
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $captchaConfig = $this->config["reCaptcha"];
        $validationRequest = new Curl();

        $url = $captchaConfig["verification_url"];
        $siteKey = $captchaConfig["site_key"];
        $clientToken = $request->getParam("recaptcha");
        $clientIpAddress = $request->getAttribute("ip_address");

        $validationRequest->post($url,[
            'secret' => $siteKey,
            'response' => $clientToken,
            'remoteip' => $clientIpAddress
        ]);

        if($validationRequest->error ){
            throw new UnauthorizedException("ReCaptcha API call failed with code ". $validationRequest->error_code. ". Message from Google API: ". $validationRequest->error_message);
        }
        $response = json_decode($validationRequest->response);

        if(!$response->succcess){
            throw new UnauthorizedException("Request failed on Recaptcha validation. Reason(s): ". json_encode($response["error-codes"]));
        }

        return $next($request,$response);
    }
}