<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 12. 19.
 * Time: 17:50
 */

namespace MedevSlim\Core\Database\SQL;


use Medoo\Medoo;

class SQLRepository
{
    /**
     * @var Medoo
     */
    protected $db;

    /**
     * SQLRepository constructor.
     * @param Medoo $db
     */
    public function __construct(Medoo $db)
    {
        $this->db = $db;
    }
}