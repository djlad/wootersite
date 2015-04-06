<?

$app->ajax('/admin/sports/ajax/checkUrl', function () use ($app) {

    /**
     * @var Admin $admin
     * @var string $url
     */

    session_start();

    $post = new Post();

    $post->addRule('url', array('required' => array("")));

    if ($post->validate()) {

        $admin = $app->getModule('admin', 'admin', false, array($app));

        if (!$admin->isLogin()) {
            die();
        }

        extract($post->getValues());

        $res = $admin->checkSportUrl($url) ? true : false;

        echo json_encode(array('exists' => $res));

    } else {

        echo "valid_error";

    }

});


$app->ajax('/admin/sports/ajax/checkUrlDub', function () use ($app) {

    /**
     * @var Admin $admin
     * @var string $url
     * @var int $id
     */

    session_start();

    $post = new Post();

    $post->addRule('url', array('required' => array("")));
    $post->addRule('id', array('required' => array("")));

    if ($post->validate()) {

        $admin = $app->getModule('admin', 'admin', false, array($app));

        if (!$admin->isLogin()) {
            die();
        }

        extract($post->getValues());

        $res = $admin->checkSportUrlDub($id, $url) ? true : false;

        echo json_encode(array('exists' => $res));

    } else {

        echo "valid_error";

    }

});


$app->ajax('/admin/sports/ajax/add', function () use ($app) {

    /**
     * @var Admin $admin
     */

    session_start();

    $post = new Post();

    $post->addRule('url', array('required' => array("")));
    $post->addRule('name', array('required' => array("")));

    if ($post->validate()) {

        $admin = $app->getModule('admin', 'admin', false, array($app));

        if (!$admin->isLogin()) {
            die();
        }

        if ($admin->addSport($post->getValues())) {

            echo json_encode(array('status' => 'ok'));

        } else {

            echo json_encode(array('status' => 'fail'));

        }

    } else {

        echo "valid_error";

    }

});


$app->ajax('/admin/sports/ajax/delete', function () use ($app) {

    /**
     * @var Admin $admin
     * @var int $id
     */

    session_start();

    $post = new Post();

    $post->addRule('id', array('required' => array("")));
    $post->addRule('act', array('required' => array("")));

    if ($post->validate()) {

        $admin = $app->getModule('admin', 'admin', false, array($app));

        if (!$admin->isLogin()) {
            die();
        }

        extract($post->getValues());

        if ($admin->deleteSport($id)) {

            echo json_encode(array('status' => 'ok'));

        } else {

            echo json_encode(array('status' => 'fail'));

        }

    } else {

        echo "valid_error";

    }

});


$app->ajax('/admin/sports/ajax/edit/:id', function ($id) use ($app) {

    /**
     * @var Admin $admin
     */

    session_start();

    $post = new Post();

    $post->addRule('url', array('required' => array("")));
    $post->addRule('name', array('required' => array("")));

    if ($post->validate()) {

        $admin = $app->getModule('admin', 'admin', false, array($app));

        if (!$admin->isLogin()) {
            die();
        }

        $data = $post->getValues();

        if ($admin->editSport($data, $id)) {

            echo json_encode(array('status' => 'ok'));

        } else {

            echo json_encode(array('status' => 'fail'));

        }

    } else {

        echo "valid_error";

    }


})->condition(array("id" => "int"));