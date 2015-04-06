<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 01.04.2015
 * Time: 17:14
 */

$app -> get('/vendor-cabinet', function () use ($app) {
    /**
     * @var Vendor $vendorObj
     */
    $vendorObj = $app->getModule('Vendor', 'main', false, array($app));
    $tpl = new Template();

    $tpl->display('vendor-cabinet', 'main');

});

include('ajax/index.php');

