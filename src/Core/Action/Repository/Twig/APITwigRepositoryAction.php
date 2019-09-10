<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 09. 10.
 * Time: 13:49
 */

namespace MedevSlim\Core\Action\Repository\Twig;


use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Service\View\TwigAPIService;
use MedevSlim\Core\View\TwigView;
use Slim\Views\Twig;

abstract class APITwigRepositoryAction extends APIRepositoryAction
{
    /**
     * @var Twig
     */
    private $view;

    /**
     * @inheritDoc
     */
    public function __construct(TwigAPIService $service)
    {
        $this->view = $service->getContainer()->get(TwigView::class);
        parent::__construct($service);
    }


    /**
     * @param string $template
     * @param array $data
     * @return string
     */
    protected function render($template, $data = []){
        return $this->view->fetch("@".$this->service->getServiceName()."/".$template,$data);
    }
}