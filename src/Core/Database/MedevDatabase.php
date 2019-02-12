<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 01. 27.
 * Time: 12:41
 */

namespace MedevSlim\Core\Database;


use MedevSlim\Core\DependencyInjection\DependencyInjector;

abstract class MedevDatabase implements DependencyInjector
{
    //We just need the name of the class to use in the DIC component key (MedevDatabase::class)
}