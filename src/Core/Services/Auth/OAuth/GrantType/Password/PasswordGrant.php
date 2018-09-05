<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 02.
 * Time: 19:40
 */

namespace MedevSlim\Core\Services\Auth\OAuth\GrantType\Password;


use MedevSlim\Core\Services\Auth\OAuth\GrantType\GrantType;


use MedevSlim\Core\Services\Auth\OAuth\GrantType\RefreshToken\RefreshTokenGrant;
use MedevSlim\Core\Services\Auth\OAuth\OAuthService;
use MedevSlim\Core\Services\Auth\OAuth\Repository\UserAuthRepository;
use MedevSuite\Application\Auth\OAuth\Token\TokenRepository;
use Psr\Container\ContainerInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class PasswordGrant extends GrantType
{

    /**
     * @var TokenRepository
     */
    private $refreshTokens;
    /**
     * @var UserAuthRepository
     */
    private $users;

    private $grantWithRefreshToken;


    public function __construct(ContainerInterface $container, $grantWithRefreshToken = false)
    {
        $this->grantWithRefreshToken = $grantWithRefreshToken;
        parent::__construct($container);
    }


    protected function validateCredentials(Request $request)
    {
        $username = $request->getParsedBodyParam("username","");
        $password = $request->getParsedBodyParam("password","");

        return $this->users->IsCredentialsValid($username,$password);
    }

    protected function grantAccess(Response $response, $args = [])
    {
        $data = [];


        $accessToken = $this->accessTokens->generateToken($args);
        $this->accessTokens->persistToken($accessToken);

        $data["access_token"] = $accessToken;


        if ($this->grantWithRefreshToken) {

            $refreshToken = $this->refreshTokens->generateToken($args);
            $this->refreshTokens->persistToken($accessToken);

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
        $this->refreshTokens = $tokenRepository;
    }

    public function setUserDataProvider(UserAuthRepository $userRepository)
    {
        $this->users = $userRepository;
    }
}