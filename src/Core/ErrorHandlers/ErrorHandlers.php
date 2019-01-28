<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 01. 28.
 * Time: 10:30
 */

namespace MedevSlim\Core\ErrorHandlers;


use MedevSlim\Core\DependencyInjection\DependencyInjector;
use Psr\Container\ContainerInterface;

class ErrorHandlers implements DependencyInjector
{

    /**
     * @param ContainerInterface $container
     */
    static function inject(ContainerInterface $container)
    {
        APIExceptionHandler::inject($container);
        NotFoundHandler::inject($container);
        NotAllowedHandler::inject($container);
        PHPRuntimeHandler::inject($container);
    }
}