<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 10.
 * Time: 10:21
 */

namespace MedevSuite\Application\Auth\OAuth\Token;


interface TokenRepository
{
    public function generateToken($args = []);

    public function persistToken($token);

    public function revokeToken($tokenId);

    public function validateToken($serializedToken);
}