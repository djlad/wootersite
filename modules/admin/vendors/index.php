<?
$app->get('/admin/vendors(/order/:by/:order)',
    function ($by = '', $order = '') use ($app) {
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

        $info = $admin->getVendors($by, $order);

        $tpl = new Template();

        $tpl->addVar('title', "Admin | Vendors");
        $tpl->addVar('info', $info);
        $tpl->addVar('by', $by);
        $tpl->addVar('order', $order);

        $content = $tpl->display('index', 'admin', 'vendors', true);

        $tpl->addVar('menu', $menu);
        $tpl->addVar('content', $content);
        $tpl->display('main', 'admin');

    })->condition(array('by' => array('company_name', 'cdate', 'prom_count', 'email', 'modified', 'sport_count', 'color', 'percent'), 'order' => array('asc', 'desc')));

$app->get('/admin/vendors/add', function () use ($app) {
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

    $tpl->addVar('title', "Admin | Vendors | Add");

    $content = $tpl->display('add', 'admin', 'vendors', true);

    $tpl->addVar('menu', $menu);
    $tpl->addVar('content', $content);
    $tpl->display('main', 'admin');

});

$app->get('/admin/vendors/company/:vendor_id(/:sport_id)', function ($vendor_id, $sport_id = 0) use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {

        header("Location:/admin/login");
        die();

    }

    $vendorSport = $admin->getVendorSports($vendor_id);

    if (!$sport_id) {

        $sport_id = (isset ($vendorSport[0]) ? $vendorSport[0]['id'] : 0);

    }

    $menu = $admin->getAdminMenu('/admin/vendors');
    $info = $admin->companyInfo($vendor_id);
    $promInfo = $admin->getVendorPromotion($vendor_id, $sport_id);
    $gallery = $admin->getVendorGallery($vendor_id);
    $gallery_prev = $admin->getVendorGalleryPrev($vendor_id);
    $sports = $admin->getSportsToVendor($vendor_id);
    $sportInfo = $admin->getSportInfo($sport_id);
    $edit_info = $admin->getEditInfo($vendor_id);

    $tpl = new Template();

    $prom_gallery = [];
    $prom_edit = [];
    $edit_price = [];
    $prices = [];

    if ($promInfo) {

        foreach ($promInfo as $prom) {

            $prices[$prom['id']] = $admin->getPromPrice($prom['id']);

            if ($prices[$prom['id']]) {

                foreach ($prices[$prom['id']] as $val) {

                    $edit_price [$val['id']] = $admin->getEditPrice($val['id']);

                }

            }

            $prom_gallery = array_merge($prom_gallery, $admin->getPromGallery($prom['id']));
            $prom_edit [$prom['id']] = $admin->getPromEditable($prom['id']);

        }

        $tpl->addVar('prices', $prices);

    } else {

        if ($sport_id) {

            $admin->createPromotions($sport_id, $vendor_id);

            header("Location:/admin/vendors/company/{$vendor_id}/{$sport_id}");

        }

    }

    $tpl->addVar('title', "Admin | Vendors | Promotion");
    $tpl->addVar('id', $vendor_id);
    $tpl->addvar('sport_id', $sport_id);
    $tpl->addVar('info', $info);
    $tpl->addVar('gallery', $gallery);
    $tpl->addVar('edit_info', $edit_info);
    $tpl->addVar('gallery_prev', $gallery_prev);
    $tpl->addVar('adminObj', $admin);
    $tpl->addVar('sports', $sports);
    $tpl->addVar('prom_edit', $prom_edit);
    $tpl->addVar('edit_price', $edit_price);
    $tpl->addVar('prom_gallery', $prom_gallery);
    $tpl->addVar('this_prom', true);
    $tpl->addVar('promInfo', $promInfo);
    $tpl->addVar('vendorSport', $vendorSport);
    $tpl->addVar('sportInfo', $sportInfo);
    $tpl->addVar('hasSport', false);

    $content = $tpl->display('company', 'admin', 'vendors', true);

    $tpl->addVar('menu', $menu);
    $tpl->addVar('content', $content);
    $tpl->display('main', 'admin');

})->condition(array('vendor_id' => 'int', 'sports_id' => 'int'));

$app->get('/admin/vendors/edit/:id', function ($id) use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {

        header("Location:/admin/login");
        die();

    }

    $info = $admin->getVendorInfo($id);

    if (!$info) {

        $app->setError('404');

    }

    $menu = $admin->getAdminMenu('/admin/vendors');

    $tpl = new Template();

    $tpl->addVar('title', "Admin | Vendors | Edit");
    $tpl->addVar('info', $info);
    $tpl->addVar('id', $id);

    $content = $tpl->display('edit', 'admin', 'vendors', true);

    $tpl->addVar('menu', $menu);
    $tpl->addVar('content', $content);
    $tpl->display('main', 'admin');

})->condition(['id' => 'int']);

include('ajax/index.php');

$app->run();