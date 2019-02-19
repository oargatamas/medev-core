<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 19.
 * Time: 14:59
 */

namespace MedevSlim\Core\Action\Servlet\Twig;


use MedevSlim\Core\Action\Servlet\APIServlet;
use MedevSlim\Core\Service\View\TwigAPIService;
use MedevSlim\Core\View\TwigView;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

/**
 * Class APITwigServlet
 * @package MedevSlim\Core\Action\Servlet\Twig
 */
abstract class APITwigServlet extends APIServlet
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
     * @param ResponseInterface $response
     * @param string $template
     * @param array $data
     * @return ResponseInterface
     */
    protected function render(ResponseInterface $response, $template, $data = []){
        return $this->view->render($response,"@".$this->service->getServiceName()."/".$template,$data);
    }
}