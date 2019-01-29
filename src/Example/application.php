<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 01. 28.
 * Time: 10:26
 */

use MedevSlim\Core\Application\MedevApp;
use MedevSlim\Example\Service\Test\TestService;

include(__DIR__ . "/../../vendor/autoload.php");


$application = new MedevApp();

$application->addAPIService("/test", new TestService($application));

$application->run();

