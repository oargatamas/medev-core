<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 01. 27.
 * Time: 12:46
 */

namespace MedevSlim\Core\DependencyInjection;


use Psr\Container\ContainerInterface;

/**
 * Interface DependencyInjector
 * @package MedevSlim\Core\DependencyInjection
 */
interface DependencyInjector
{
    /**
     * @param ContainerInterface $container
     */
    static function inject(ContainerInterface $container);
}