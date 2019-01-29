<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 01. 28.
 * Time: 12:36
 */

namespace MedevSlim\Example\Service\Test;


use MedevSlim\Core\Action\Middleware\RequestValidator;
use MedevSlim\Core\Action\Middleware\ScopeValidator;
use MedevSlim\Core\Service\APIService;
use MedevSlim\Example\Service\Test\Action\TestServletAction\TestServletAction;
use Slim\App;

class TestService extends APIService
{

    /**
     * @return mixed
     */
    public function getServiceName()
    {
        return "TestService";
    }

    /**
     * @param App $app
     */
    protected function registerRoutes(App $app)
    {
        $app->any("/json",new TestServletAction($this))
            ->add(new ScopeValidator(TestServletAction::getScopes()))
            ->add(new RequestValidator(TestServletAction::getParams()))
            ->setName($this->getServiceName());
    }
}