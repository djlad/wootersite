<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 02.04.2015
 * Time: 17:09
 */

$app->ajax('/vendor-cabinet/ajax/logoImage', function () use ($app) {
    /**
     * @var Vendor $vendorObj
     */
    $vendorObj = $app->getModule('Vendor', 'main', false, array($app));
    $file = $_FILES['file'];
    if (preg_match('/^image/isu', $file['type']) && $file['error'] == 0) {
        $data = file_get_contents($file['tmp_name']);
        $base64 = 'data:' . $file['type'] . ';base64,' . base64_encode($data);
        echo json_encode(['status' => 'success', 'base64' => $base64]);
    }
});

$app->run();