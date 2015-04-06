<?

$app->get('/admin/promotion', function () use ($app) {

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

    $info = $admin->getValidatePromotion();

    $tpl->addVar('title', "Admin | Promotion");
    $tpl->addVar('info', $info);

    $content = $tpl->display('index', 'admin', 'promotion', true);

    $tpl->addVar('menu', $menu);
    $tpl->addVar('content', $content);
    $tpl->display('main', 'admin');

});

include('ajax/index.php');

$app->run();