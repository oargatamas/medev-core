<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 02.
 * Time: 19:40
 */

namespace MedevSlim\Core\Services\Auth\OAuth\GrantType\Password;


use MedevSlim\Core\Services\Auth\OAuth\GrantType\GrantType;

use MedevSlim\Core\Services\Auth\OAuth\Repository\UserRepository;
use MedevSuite\Application\Auth\OAuth\Token\TokenRepository;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class PasswordGrant extends GrantType
{

    /**
     * @var TokenRepository
     */
    private $refreshTokenRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    private $grantWithRefreshToken;



    public function __construct($grantWithRefreshToken = false)
    {
        $this->grantWithRefreshToken = $grantWithRefreshToken;
    }


    protected function validateCredentials(Request $request)
    {
        $username = $request->getParsedBodyParam("username","");
        $password = $request->getParsedBodyParam("password","");

        return $this->userRepository->IsCredentialsValid($username,$password);
    }

    protected function grantAccess(Response $response, $args = [])
    {
        $data = [];

        $accessToken = $this->accessTokenRepository->generateToken($args);
        $this->accessTokenRepository->persistToken($accessToken);


        $data["token_type"] = "Bearer";
        $data["access_token"] = $accessToken;


        if ($this->grantWithRefreshToken) {

            $refreshToken = $this->refreshTokenRepository->generateToken($args);
            $this->refreshTokenRepository->persistToken($accessToken);

            $data["refresh_token"] = $refreshToken;
        }


        $response->withStatus(200);
        $response->withJson($data);
        return $response;
    }


    public function getName()
    {
        return "password";
    }

    public function setRefreshTokenProvider(TokenRepository $tokenRepository)
    {
        $this->refreshTokenRepository = $tokenRepository;
    }

    public function setUserDataProvider(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
}