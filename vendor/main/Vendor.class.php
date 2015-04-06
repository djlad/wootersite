<?php

/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 01.04.2015
 * Time: 17:16
 */
class Vendor
{
    /**
     * @var int
     * @var int $id
     */
    public $id  = 135;

    public function __construct($app)
    {
        $this->app = $app;
        $this->dbRead = db::getInstance('read');
        $this->dbWrite = db::getInstance('write');
    }



} 