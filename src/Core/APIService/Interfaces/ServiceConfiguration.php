<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 08.
 * Time: 16:04
 */

namespace MedevSlim\Core\APIService\Interfaces;


interface ServiceConfiguration
{
    public function getConfigName();
    public function getConfig();
    public function get($name);
}