<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 12.
 * Time: 10:06
 */

namespace MedevSlim\Core\Logging;


/**
 * Interface ComponentLogger
 * @package MedevSlim\Core\Logging
 */
interface ComponentLogger
{
    /**
     * @param string $message
     * @param array $args
     */
    public function debug($message, $args = []);

    /**
     * @param string $message
     * @param array $args
     */
    public function info($message, $args = []);

    /**
     * @param string $message
     * @param array $args
     */
    public function warn($message, $args = []);

    /**
     * @param string $message
     * @param array $args
     */
    public function error($message, $args = []);
}