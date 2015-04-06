<?
$app->get('/admin/sports', function () use ($app) {

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

    $info = $admin->getAllSports();

    $tpl->addVar('title', "Admin | Sports");
    $tpl->addVar('info', $info);

    $content = $tpl->display('index', 'admin', 'sports', true);

    $tpl->addVar('menu', $menu);
    $tpl->addVar('content', $content);
    $tpl->display('main', 'admin');

});

$app->get('/admin/sports/add', function () use ($app) {

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

    $tpl->addVar('title', "Admin | Sports | Add");

    $content = $tpl->display('add', 'admin', 'sports', true);

    $tpl->addVar('menu', $menu);
    $tpl->addVar('content', $content);
    $tpl->display('main', 'admin');


});

$app->get('/admin/sports/edit/:id', function ($id) use ($app) {

    /**
     * @var Admin $admin
     */

    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {

        header("Location:/admin/login");
        die();
    }

    $menu = $admin->getAdminMenu('/admin/sports');

    $info = $admin->getSports($id);

    if (!$info) {

        $app->setError('404');

    }

    $tpl = new Template();

    $tpl->addVar('title', "Admin | Sports | Edit | {$info['name']}");
    $tpl->addVar('info', $info);

    $content = $tpl->display('edit', 'admin', 'sports', true);

    $tpl->addVar('menu', $menu);
    $tpl->addVar('content', $content);
    $tpl->display('main', 'admin');

})->condition(array("id" => "int"));

include('ajax/index.php');

$app->run();