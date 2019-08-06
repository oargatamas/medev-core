<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 12.
 * Time: 17:36
 */


use MedevSlim\Core\Application\MedevApp;
use MedevSlimExample\Services\Dummy\DummyService;

$configJson = file_get_contents(__DIR__."/../config/config.json");
$config = json_decode($configJson,true);

$application = MedevApp::fromJsonFile(__DIR__."/../config/config.json");
\MedevSlim\Core\View\TwigView::inject($application->getContainer());


$application->addAPIService("/test",new DummyService($application));

//registering other services or application middlewares....

$application->run();