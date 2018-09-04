<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 15.
 * Time: 16:07
 */

namespace MedevSuite\Application\Auth\OAuth\Token\JWT;


 use MedevSuite\Application\Auth\OAuth\Token\TokenProvider;
 use MedevSuite\Utils\UUID\UUID;

 abstract class JWTProvider implements TokenProvider
{

     protected $jti;

     public function __construct()
     {
         $this->jti = UUID::generate(random_bytes(16));
     }

     public function getTokenId()
     {
         return $this->jti;
     }


 }