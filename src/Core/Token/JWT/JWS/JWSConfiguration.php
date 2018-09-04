<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 03.
 * Time: 13:29
 */

namespace MedevSlim\Core\Token\JWT\JWS;


class JWSConfiguration
{
    private $privateKey;
    private $publicKey;
    private $expiration;


    public function getPrivateKey()
    {
        return $this->privateKey;
    }


    public function setPrivateKey($pathToKey)
    {
        $this->privateKey = $pathToKey;
    }


    public function getPublicKey()
    {
        return $this->publicKey;
    }


    public function setPublicKey($pathToKey)
    {
        $this->publicKey = $pathToKey;
    }


    public function getExpiration()
    {
        return $this->expiration;
    }


    public function setExpiration($expiration)
    {
        $this->expiration = $expiration;
    }


}