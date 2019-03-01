<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 12.
 * Time: 9:19
 */

namespace MedevSlim\Core\Database\Medoo;


use MedevSlim\Core\Database\MedevDatabase;
use Medoo\Medoo;
use Psr\Container\ContainerInterface;

class MedooDatabase extends MedevDatabase
{
    const DEFAULT_DATE_FORMAT = "Y-m-d H:i:s";
    /**
     * @param ContainerInterface $container
     */
    static function inject(ContainerInterface $container)
    {
        $container[MedevDatabase::class] = function() use ($container){
            $config = $container->get("settings");
            return new Medoo($config["database"]);
        };
    }
}