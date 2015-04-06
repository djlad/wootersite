<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 31.03.2015
 * Time: 11:39
 */

$app->ajax('/admin/you-doing/ajax/addImage', function () use ($app) {

    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $file = $_FILES['file'];

    if ($file['error'] == 0) {
        $data = file_get_contents($file['tmp_name']);
        $base64 = 'data:' . $file['type'] . ';base64,' . base64_encode($data);

        echo json_encode(['status' => 'success', 'base64' => $base64]);
    } else {
        echo json_encode(['status' => 'fail', 'msg' => 'Upload error']);
    }

});

$app->ajax('/admin/you-doing/ajax/add', function () use ($app) {

    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post();

    $post->addRule('title', array('required' => array("")));
    $post->addRule('description', array('required' => array("")));

    if ($post->validate()) {
        $response = $post->getValues();

        $path = $_SERVER['DOCUMENT_ROOT'];
        $base64 = explode(',', $response['image_base64']);
        $name = uniqid();
        preg_match('/\/([a-z]*);/siu', $base64[0], $extension);
        $image = $name . '.' . $extension[1];
        file_put_contents($path . '/upload/you-doing/' . $image, base64_decode($base64[1]));

        echo json_encode(['status' => $admin->addDoing(array_merge(['image' => $image], $response)) ? 'ok' : 'fail']);
    } else {
        echo json_encode(['status' => 'valid error']);
    }

});

$app->ajax('/admin/you-doing/ajax/edit/:id', function ($id) use ($app) {

    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post();

    $post->addRule('title', array('required' => array("")));
    $post->addRule('description', array('required' => array("")));

    if ($post->validate()) {
        $response = $post->getValues();

        $path = $_SERVER['DOCUMENT_ROOT'];
        $base64 = explode(',', $response['image_base64']);
        $name = uniqid();
        preg_match('/\/([a-z]*);/siu', $base64[0], $extension);
        $image = $name . '.' . $extension[1];
        file_put_contents($path . '/upload/you-doing/' . $image, base64_decode($base64[1]));

        echo json_encode(['status' => $admin->editDoing(array_merge(['image' => $image], $response), $id) ? 'ok' : 'fail']);
    } else {
        echo json_encode(['status' => 'valid error']);
    }

})->condition(['id' => 'int']);

$app->ajax('/admin/you-doing/ajax/delete', function () use ($app) {

    /**
     * @var Admin $admin
     * @var int $id
     * @var string $act
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post();

    $post->addRule('act', ['required' => []]);
    $post->addRule('id', ['required' => []]);

    if ($post->validate()) {
        extract($post->getValues());
        switch ($act) {
            case 'delete':
                echo json_encode(['status' => $admin->dbWrite->delete('doing', "id=" . $id) ? 'ok' : 'fail']);
                break;
        }
    }

});