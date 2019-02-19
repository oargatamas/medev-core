<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 19.
 * Time: 14:40
 */

namespace MedevSlim\Core\Service\View;



use MedevSlim\Core\Service\APIService;
use MedevSlim\Core\View\TwigView;
use Psr\Container\ContainerInterface;
use Twig\Loader\FilesystemLoader;

/**
 * Class TwigAPIService
 * @package MedevSlim\Core\Service\View
 */
abstract class TwigAPIService extends APIService
{

    /**
     * @inheritDoc
     */
    protected function registerContainerComponents(ContainerInterface $container)
    {
        parent::registerContainerComponents($container);

        /** @var FilesystemLoader $viewloader */
        $viewLoader = $container->get(TwigView::loader);
        $viewLoader->addPath(__DIR__."/View",$this->getServiceName());

    }
}