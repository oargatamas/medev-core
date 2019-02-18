<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 18.
 * Time: 13:18
 */

namespace MedevSlim\Core\Action\Servlet\Session;


use MedevSlim\Core\Action\Servlet\APIServletAction;

/**
 * Class APISessionServletAction
 * @package MedevSlim\Core\Action\Servlet\Session
 */
abstract class APISessionServletAction extends APIServletAction
{

    /**
     * @return void
     * @throws \Exception
     */
    protected function startSession(){
        $this->info("Attempting to start session.");
        if(session_status() == PHP_SESSION_NONE){
            session_start();
            $this->info("Session invalid or not set. Starting new one. (".session_id().")");
        }else{
            $this->info("Using existing session. (".session_id().")");
        }
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function stopSession(){
        $this->info("Attempting to invalidate session. (".session_id().")");
        session_destroy();
        $this->info("Session invalidated.");
    }
}