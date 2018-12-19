<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 12. 19.
 * Time: 17:51
 */

namespace MedevSlim\Core\Database\SQL\Schema;


use Medoo\Medoo;

abstract class SQLSchema
{
    /**
     * @var string
     */
    protected $prefix;

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * @param Medoo $database
     * @return void
     */
    public abstract function init(Medoo $database);
}