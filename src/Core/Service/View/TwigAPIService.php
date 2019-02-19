<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 19.
 * Time: 14:40
 */

namespace MedevSlim\Core\Service\View;


use MedevSlim\Core\Application\MedevApp;
use MedevSlim\Core\Service\APIService;
use MedevSlim\Core\View\TwigView;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;
use Twig\Loader\FilesystemLoader;

/**
 * Class TwigAPIService
 * @package MedevSlim\Core\Service\View
 */
abstract class TwigAPIService extends APIService
{
    /**
     * @var Twig
     */
    private $view;

    /**
     * @inheritDoc
     */
    public function __construct(MedevApp $app)
    {
        parent::__construct($app);
        $this->view = $app->getContainer()->get(TwigView::class);
    }


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


    /**
     * @param ResponseInterface $response
     * @param string $template
     * @param array $data
     * @return ResponseInterface
     */
    protected function render(ResponseInterface $response, $template, $data = []){
        return $this->view->render($response,"@".$this->getServiceName()."/".$template,$data);
    }
}