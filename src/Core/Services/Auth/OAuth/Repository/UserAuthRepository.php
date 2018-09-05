<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 05.
 * Time: 9:31
 */

namespace MedevSlim\Core\Services\Auth\OAuth\Repository;




interface UserAuthRepository
{
    public function IsCredentialsValid($username, $password);
    public function getUserData($username);
}