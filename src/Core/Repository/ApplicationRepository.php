<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 04.
 * Time: 11:11
 */

namespace MedevSlim\Core\Repository;


use Psr\Container\ContainerInterface;

class ApplicationRepository
{
    private $db;

    /**
     * ApplicationRepository constructor.
     */
    public function __construct(ContainerInterface $container)
    {
        $this->db = $container->get("database");
    }


}