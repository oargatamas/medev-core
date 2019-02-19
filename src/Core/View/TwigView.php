<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 19.
 * Time: 14:49
 */

namespace MedevSlim\Core\View;


use MedevSlim\Core\DependencyInjection\DependencyInjector;
use Psr\Container\ContainerInterface;
use Slim\Http\Environment;
use Slim\Http\Uri;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Twig\Loader\FilesystemLoader;

class TwigView implements DependencyInjector
{
    const loader = "view_loader";

    /**
     * @param ContainerInterface $container
     */
    static function inject(ContainerInterface $container)
    {
        $container[TwigView::loader] = function (){
            return new FilesystemLoader("view");
        };

        $container[TwigView::class] = function() use($container){
            $view = new Twig("");

            // Instantiate and add Slim specific extension
            $router = $container->get('router');
            $uri = Uri::createFromEnvironment(new Environment($_SERVER));
            $view->addExtension(new TwigExtension($router, $uri));
            $view->getEnvironment()->setLoader($container->get("view_loader"));

            return $view;
        };
    }
}