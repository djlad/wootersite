<?

$app->ajax('/admin/ajax/login', function () use ($app) {
    /**
     * @var string $login
     * @var string $pswd
     * @var Admin $admin
     */
    if (empty ($_POST['pswd']) || empty($_POST['login'])) {

        echo json_encode(array('status' => 'fail', 'msg' => 'Enter Login/Password'));

    } else {

        session_start();

        $post = new Post ();

        $admin = $app->getModule('admin', 'admin', false, array($app));

        extract($post->getValues());

        if ($id = $admin->login($login, $pswd)) {

            $_SESSION['admin_id'] = $id;

            echo json_encode(array('status' => 'ok'));

        } else {

            echo json_encode(array('status' => 'fail', 'msg' => 'Incorrect Login/Password'));

        }

    }

});

$app->ajax('/admin/ajax/EditPswd', function () use ($app) {
    /**
     * @var string $pswd
     * @var string $re_pswd
     */
    session_start();

    $post = new Post ();
    $post->addRule('pswd', array("required" => array("")));
    $post->addRule('re_pswd', array("required" => array("")));

    if ($post->validate()) {

        $admin = $app->getModule('admin', 'admin', false, array($app));

        extract($post->getValues());

        if ($pswd === $re_pswd) {

            if (!$admin->isLogin()) {
                die();
            }

            if ($admin->editPswd($pswd)) {

                session_destroy();

                echo json_encode(array('status' => 'ok'));

            }

        } else {

            echo json_encode(array('status' => 'fail', 'msg' => 'Error'));

        }

    } else {

        echo "valid_error";

    }

});

$app->run();
