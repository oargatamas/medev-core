<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 12.
 * Time: 17:41
 */

namespace MedevSlimExample\Services\Dummy;


use MedevSlim\Core\Service\APIService;
use MedevSlim\Core\Service\View\TwigAPIService;
use MedevSlimExample\Services\Dummy\Actions\DummyHTTP;
use Slim\App;

class DummyService extends TwigAPIService
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
     * @throws \Exception
     */
    protected function registerRoutes(App $app)
    {

        //examples for logging:
        $this->debug("Debug message");
        $this->info("Info message");
        $this->warn("Warning message");
        $this->error("Error message");


        $app->get("/{number}/dummy", new DummyHTTP($this))
            //->add(new ScopeValidator(DummyHTTP::getScopes()))   //Override getScopes method in the action to add more scopes to validate
            //->add(new RequestValidator(DummyHTTP::getParams())) //Override getParams method in the action to add more scopes to validate
            ->setArgument(APIService::SERVICE_ID, $this->getServiceName())
            ->setName("DummyRoute");
    }

    protected function getTemplatePath()
    {
        return __DIR__ . "/View";
    }
}