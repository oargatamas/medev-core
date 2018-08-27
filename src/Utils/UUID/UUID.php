<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 10.
 * Time: 16:19
 */

namespace MedevSuite\Utils\UUID;


class UUID
{
    //Stoled from stackoverflow: https://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid
    public static function generate($data)
    {
        assert(strlen($data) == 16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

    }
}