<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 09. 10.
 * Time: 13:49
 */

namespace MedevSlim\Core\Action\Repository\Twig;


use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Application\MedevApp;
use MedevSlim\Core\Service\View\TwigAPIService;
use MedevSlim\Core\View\TwigView;
use Slim\Interfaces\RouterInterface;
use Slim\Views\Twig;

abstract class APITwigRepositoryAction extends APIRepositoryAction
{
    /**
     * @var Twig
     */
    private $view;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @inheritDoc
     */
    public function __construct(TwigAPIService $service)
    {
        $this->view = $service->getContainer()->get(TwigView::class);
        $this->router = $service->getContainer()->get(MedevApp::ROUTER);
        parent::__construct($service);
    }


    /**
     * @param string $template
     * @param array $data
     * @return string
     * @throws \Twig\Error\LoaderError
     */
    protected function render($template, $data = []){
        return $this->view->fetch("@".$this->service->getServiceName()."/".$template,$data);
    }
}