<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 30.03.2015
 * Time: 18:51
 *
 * @var Sport $sportObj
 */
$app->ajax('/ajax/getAllSport', function () use ($app) {
    /**
     * @var Sport $sportObj
     */
    $sportObj = $app->getModule('admin', 'admin', false, array($app));

    echo json_encode ([
        'status' => 'success',
        'stages' => $sportObj->getAllSports(),
    ]);

});

$app->run();