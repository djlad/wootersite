<?php

/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 30.03.2015
 * Time: 18:56
 *
 * Class Sport
 */
class Sport
{
    /**
     * @param $app
     */
    public function __construct($app)
    {
        $this->app = $app;
        $this->dbRead = db::getInstance('read');
        $this->dbWrite = db::getInstance('write');
    }

    /**
     * @return array|bool
     * @throws Exception
     */
    function getAllSports()
    {
       return  $this->dbRead->select("SELECT id, name FROM sports");
    }

} 