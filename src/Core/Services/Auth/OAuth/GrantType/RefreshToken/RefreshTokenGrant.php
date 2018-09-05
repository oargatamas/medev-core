<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 02.
 * Time: 19:39
 */

namespace MedevSlim\Core\Services\Auth\OAuth\GrantType\RefreshToken;



use MedevSlim\Core\Services\Auth\OAuth\GrantType\GrantType;
use MedevSuite\Application\Auth\OAuth\Token\TokenRepository;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class RefreshTokenGrant extends GrantType
{

    /**
     * @var TokenRepository
     */
    private $refreshTokens;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }


    public function getName()
    {
        return "refresh_token";
    }

    protected function validateCredentials(Request $request)
    {
        $refreshToken = $request->getParsedBodyParam("refresh_token","");

        return $this->refreshTokens->validateToken($refreshToken);
    }


    protected function grantAccess(Response $response, $args = [])
    {
        $data = [];

        $accessToken = $this->accessTokens->generateToken($args);
        $this->accessTokens->persistToken($accessToken);

        $data["access_token"] = $accessToken;

        $response->withStatus(200);
        $response->withJson($data);
        return $response;
    }

    public function setRefreshTokenProvider(TokenRepository $tokenRepository)
    {
        $this->refreshTokens = $tokenRepository;
    }
}