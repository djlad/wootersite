<?

$app->ajax('/admin/users/ajax/delete', function () use ($app) {

    /**
     * @var int $id
     * @var Admin $admin
     */

    session_start();

    $post = new Post ();

    $post->addRule('act', array('required' => array("")), array('regexp' => array('latin', '')));
    $post->addRule('id', array('required' => array("")), array('regexp' => array('int', '')));

    if ($post->validate()) {

        $admin = $app->getModule('admin', 'admin', false, array($app));

        if (!$admin->isLogin()) {
            die();
        }

        extract($post->getValues());

        if ($admin->deleteUser($id)) {

            echo json_encode(array("status" => 'ok'));

        } else {

            echo json_encode(array("status" => 'fail'));

        }

    } else {

        echo "valid_error";

    }

});

$app->ajax('/admin/users/ajax/checkEmail', function () use ($app) {

    /**
     * @var string $email
     * @var Admin $admin
     */

    session_start();

    $post = new Post();

    $post->addRule('email', array('required' => array("")));

    if ($post->validate()) {

        $user = $app->getModule('user', 'main', false, array($app));
        $admin = $app->getModule('admin', 'admin', false, array($app));

        if (!$admin->isLogin()) {
            die();
        }

        extract($post->getValues());

        $res = $user->checkEmail($email) ? true : false;

        echo json_encode(array('exists' => $res));

    } else {

        echo "valid_error";

    }

});

$app->ajax('/admin/users/ajax/add', function () use ($app) {

    /**
     * @var Admin $admin
     */

    session_start();

    $post = new Post();

    $post->addRule('email', array('required' => array("")));
    $post->addRule('first_name', array('required' => array("")));
    $post->addRule('last_name', array('required' => array("")));
    $post->addRule('pswd', array('required' => array("")));
    $post->addRule('re_pswd', array('required' => array("")));

    if ($_POST['pswd'] == $_POST['re_pswd']) {

        if ($post->validate()) {

            $admin = $app->getModule('admin', 'admin', false, array($app));

            if (!$admin->isLogin()) {
                die();
            }

            $data = $post->getValues();

            if ($admin->addUser($data)) {

                echo json_encode(array("status" => 'ok'));

            } else {

                echo json_encode(array("status" => 'fail'));

            }

        } else {

            echo "valid_error";

        }

    }

});