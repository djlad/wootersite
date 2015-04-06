<?
$app->get('/admin/users', function () use ($app) {

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

    $info = $admin->getUsers();

    $tpl = new Template();

    $tpl->addVar('title', "Admin | Users");
    $tpl->addVar('info', $info);

    $content = $tpl->display('index', 'admin', 'users', true);

    $tpl->addVar('menu', $menu);
    $tpl->addVar('content', $content);
    $tpl->display('main', 'admin');

});

$app->get('/admin/users/show/:id', function ($id) use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {

        header("Location:/admin/login");
        die();
    }

    $menu = $admin->getAdminMenu('/admin/users');

    $info = $admin->getUser($id);

    if (!$info) {

        $app->setError('404');

    }

    $tpl = new Template();

    $tpl->addVar('title', "Admin | User | " . $info['first_name']);
    $tpl->addVar('info', $info);

    $content = $tpl->display('user', 'admin', 'users', true);

    $tpl->addVar('menu', $menu);
    $tpl->addVar('content', $content);
    $tpl->display('main', 'admin');

})->condition(array('id' => 'int'));

$app->get('/admin/users/add', function () use ($app) {
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

    $tpl->addVar('title', "Admin | User | Add");

    $content = $tpl->display('add', 'admin', 'users', true);

    $tpl->addVar('menu', $menu);
    $tpl->addVar('content', $content);
    $tpl->display('main', 'admin');

});

include('ajax/index.php');

$app->run();