<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 10.
 * Time: 10:21
 */

namespace MedevSuite\Application\Auth\OAuth\Token;


interface TokenProvider
{
    public function getToken($customClaims = []);

    public function persistToken($token);

    public function revokeToken($tokenId);

    public function validateToken($token);

    public function getTokenId();
}