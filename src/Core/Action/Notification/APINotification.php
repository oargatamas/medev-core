<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 09. 10.
 * Time: 13:41
 */

namespace MedevSlim\Core\Action\Notification;


use MedevSlim\Core\Action\APIServiceAction;
use MedevSlim\Core\Service\APIService;
use MedevSlim\Core\View\TwigView;
use Slim\Views\Twig;

class APINotification extends APIServiceAction
{
    /**
     * @var Twig
     */
    protected $view;

    /**
     * @inheritDoc
     */
    public function __construct(APIService $service)
    {
        parent::__construct($service);
        $this->view = $service->getContainer()->get(TwigView::class);
    }
}