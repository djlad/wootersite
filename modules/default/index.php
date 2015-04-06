<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 30.03.2015
 * Time: 15:50
 */

$app->get('/', function () use ($app) {
    /**
     * @var YouDoing $doingObj
     */
    $tpl = new Template();
    $doingObj = $app->getModule('YouDoing', 'main', false, array($app));

    $tpl->addVar('doings', $doingObj->getAll());
    $tpl->display('index', 'main');


});

$app->run();