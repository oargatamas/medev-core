<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 01. 11.
 * Time: 14:21
 */

namespace MedevSlim\Utils;


class RandomString
{
    /**
     * @return string
     */
    public static function generate()
    {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}