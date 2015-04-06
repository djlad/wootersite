<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 31.03.2015
 * Time: 13:44
 */

class YouDoing {
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
    function getAll ()
    {
        return $this->dbRead->select("SELECT * FROM doing");
    }
} 