<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 31.03.2015
 * Time: 11:05
 */

$app->get('/admin/you-doing', function () use ($app) {

    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {

        header("Location:/admin/login");
        die();
    }

    $menu = $admin->getAdminMenu();
    $all = $admin->getAllDoings();
    $tpl = new Template();

    $tpl->addVar('title', "Admin | You Doing");
    $tpl->addVar('doings', $all);

    $content = $tpl->display('index', 'admin', 'you-doing', true);

    $tpl->addVar('menu', $menu);
    $tpl->addVar('content', $content);
    $tpl->display('main', 'admin');

});

$app->get('/admin/you-doing/add', function () use ($app) {

    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {

        header("Location:/admin/login");
        die();
    }

    $menu = $admin->getAdminMenu();

    $tpl = new Template();

    $tpl->addVar('title', "Admin | You Doing | Add");

    $content = $tpl->display('add', 'admin', 'you-doing', true);

    $tpl->addVar('menu', $menu);
    $tpl->addVar('content', $content);
    $tpl->display('main', 'admin');

});

$app->get('/admin/you-doing/edit/:id', function ($id) use ($app) {

    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {

        header("Location:/admin/login");
        die();
    }

    $menu = $admin->getAdminMenu();
    $info = $admin->getDoing($id);

    if (!$info)
        $app -> setError('404');

    $tpl = new Template();

    $tpl->addVar('title', "Admin | You Doing | Edit");
    $tpl->addVar('info', $info);

    $content = $tpl->display('edit', 'admin', 'you-doing', true);

    $tpl->addVar('menu', $menu);
    $tpl->addVar('content', $content);
    $tpl->display('main', 'admin');

})->condition(['id' => 'int']);

include('ajax/index.php');

$app->run();