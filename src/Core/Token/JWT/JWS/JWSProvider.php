<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 15.
 * Time: 16:02
 */

namespace MedevSuite\Application\Auth\OAuth\Token\JWT\JWS;


use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Keychain;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Token;
use MedevSlim\Core\Token\JWT\JWS\JWSConfiguration;
use MedevSlim\Core\Token\JWT\JWS\JWSValidator;
use MedevSuite\Application\Auth\OAuth\Token\JWT\JWTProvider;

abstract class JWSProvider extends JWTProvider
{
    private $config;

    public function __construct(JWSConfiguration $config)
    {
       $this->config = $config;
    }

    public function getToken($customClaims = [])
    {
        $token = new Builder();

        $token->setId($this->jti,true);

        $token->setIssuedAt(time());
        $token->setNotBefore(time());
        $token->expiresAt(time() + $this->config->getExpiration());


        //This will apply the specialised token claims
        $this->setClaims($token,$customClaims);

        return $this->applySignature($token);
    }

    protected abstract function setClaims($token,$customClaims = []);


    protected function applySignature(Builder $token){
        $signer = new Sha256();
        $keychain = new Keychain();

        $token->sign($signer, $keychain->getPrivateKey($this->config->getPrivateKey()));

        $token = $token->getToken();

        return $token;
    }



    public function verifySignature(Token $jws){
        return (new JWSValidator($this->config))->isSignatureValid($jws);
    }


}