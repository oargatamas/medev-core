<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 04.
 * Time: 12:51
 */

namespace MedevSlim\Core\Token\JWT\JWS;


use Lcobucci\JWT\Signer\Keychain;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Token;

class JWSValidator
{

    private $config;

    public function __construct(JWSConfiguration $config)
    {
        $this->config = $config;
    }

    public function isSignatureValid(Token $jws){
        $signer = new Sha256();
        $keychain = new Keychain();

        return $jws->verify($signer, $keychain->getPublicKey($this->config->getPublicKey()));
    }

}