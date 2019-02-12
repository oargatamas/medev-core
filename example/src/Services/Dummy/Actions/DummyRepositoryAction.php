<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 12.
 * Time: 17:43
 */

namespace MedevSlimExample\Services\Dummy\Actions;


use MedevSlim\Core\Action\Repository\APIRepositoryAction;

class DummyRepositoryAction extends APIRepositoryAction
{

    /**
     * @param $args
     * @return mixed
     */
    public function handleRequest($args)
    {
        //examples for logging:
        $this->debug("Debug message");
        $this->info("Info message");
        $this->warn("Warning message");
        $this->error("Error message");


        // you can touch the database from here via $this->database
        $database = $this->database;

        return ["result" => "nothing"];
    }
}