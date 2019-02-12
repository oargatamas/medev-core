<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 12.
 * Time: 17:41
 */

namespace MedevSlimExample\Services\Dummy;


use MedevSlim\Core\Action\Middleware\RequestValidator;
use MedevSlim\Core\Action\Middleware\ScopeValidator;
use MedevSlim\Core\Service\APIService;
use MedevSlimExample\Services\Dummy\Actions\DummyHTTPAction;
use Slim\App;

class DummyService extends APIService
{

    /**
     * @return string
     */
    public function getServiceName()
    {
        return "DummyService"; //This needed for creating the correct log file for the service
    }

    /**
     * @param App $app
     */
    protected function registerRoutes(App $app)
    {

        //examples for logging:
        $this->debug("Debug message");
        $this->info("Info message");
        $this->warn("Warning message");
        $this->error("Error message");


        $app->get("/dummy", new DummyHTTPAction($this))
            ->add(new ScopeValidator(DummyHTTPAction::getScopes()))   //Override getScopes method in the action to add more scopes to validate
            ->add(new RequestValidator(DummyHTTPAction::getParams())) //Override getParams method in the action to add more scopes to validate
            ->setName($this->getServiceName());
    }
}