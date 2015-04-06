<?php

$app->get('/admin', function () use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {

        header("Location:/admin/login");
        die();
    }

    header("Location:/admin/vendors");


    $menu = $admin->getAdminMenu();

    $info = $admin->getPay();

    $tpl = new Template();

    $tpl->addVar('title', "Admin | Main");
    $tpl->addVar('info', $info);

    $content = $tpl->display('index', 'admin', '', true);

    $tpl->addVar('menu', $menu);
    $tpl->addVar('content', $content);
    $tpl->display('main', 'admin');


});

$app->get('/admin/login', function () use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if ($admin->isLogin()) {

        header("Location:/admin");

    }

    $tpl = new Template();

    $tpl->display('login', 'admin');

});

$app->get('/admin/settings', function () use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {

        header("Location:/admin/login");

    }

    $menu = $admin->getAdminMenu();

    $tpl = new Template();

    $tpl->addVar('title', "Admin | Settings");
    $content = $tpl->display('index', 'admin', 'settings', true);

    $tpl->addVar('menu', $menu);
    $tpl->addVar('content', $content);
    $tpl->display('main', 'admin');


});

$app->get('/admin/logout', function () use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    session_destroy();

    header("Location:/admin/login");

});

$app->run();
