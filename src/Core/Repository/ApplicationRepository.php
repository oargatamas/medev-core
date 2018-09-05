<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 04.
 * Time: 11:11
 */

namespace MedevSlim\Core\Repository;


use Medoo\Medoo;
use Psr\Container\ContainerInterface;
use Slim\Container;

class ApplicationRepository
{
    protected $db;

    public function __construct(Container $container)
    {
        $this->db = $container->get("database");
    }

    public function getDatabase(){
        return $this->db;
    }
}