<?

$app->ajax('/admin/vendors/ajax/delete', function () use ($app) {

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

        if ($admin->deleteVendor($id)) {

            echo json_encode(array("status" => 'ok'));

        } else {

            echo json_encode(array("status" => 'fail'));

        }

    } else {

        echo "valid_error";

    }

});

$app->ajax('/admin/vendors/ajax/checkEmail', function () use ($app) {

    /**
     * @var string $email
     * @var Admin $admin
     */
    session_start();

    $post = new Post();

    $post->addRule('email', array('required' => array("")));

    if ($post->validate()) {

        $vendor = $app->getModule('vendor', 'main', false, array($app));
        $admin = $app->getModule('admin', 'admin', false, array($app));

        if (!$admin->isLogin()) {
            die();
        }

        extract($post->getValues());

        $res = $vendor->checkEmail($email) ? true : false;

        echo json_encode(array('exists' => $res));

    } else {

        echo "valid_error";

    }


});

$app->ajax('/admin/vendors/ajax/checkEmailDublicate', function () use ($app) {

    /**
     * @var int $id
     * @var string $email
     * @var Admin $admin
     */
    session_start();

    $post = new Post();

    $post->addRule('email', array('required' => array("")));
    $post->addRule('id', array('required' => array("")));

    if ($post->validate()) {

        $admin = $app->getModule('admin', 'admin', false, array($app));

        if (!$admin->isLogin()) {
            die();
        }

        extract($post->getValues());

        $res = $admin->checkEmailDublicate($email, $id) ? true : false;

        echo json_encode(array('exists' => $res));

    } else {

        echo "valid_error";

    }


});

$app->ajax('/admin/vendors/ajax/add', function () use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $post = new Post();

    $post->addRule('email', array('required' => array("")));
    $post->addRule('pswd', array('required' => array("")));
    $post->addRule('re_pswd', array('required' => array("")));

    if ($_POST['pswd'] == $_POST['re_pswd']) {

        if ($post->validate()) {

            $admin = $app->getModule('admin', 'admin', false, array($app));

            if (!$admin->isLogin()) {
                die();
            }

            $data = $post->getValues();

            if ($id = $admin->addVendor($data)) {

                echo json_encode(array('status' => 'ok', 'id' => $id));

            } else {

                echo json_encode(array("status" => 'fail'));

            }

        } else {

            echo "valid_error";

        }

    }

});

$app->ajax('/admin/vendors/ajax/uploadImage/:id', function ($id) use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post();

    $uploadDir = '/uploads/vendors/' . $id;
    $uploadPath = './uploads/vendors/' . $id;

    $post->addFile("files", $uploadPath, array('required' => array("Upload file for continue"),
        'validExtensions' => array(array("jpg", "jpeg", "bmp", "png"), "File extension is not valid"),
        'maxSize' => array(5, "Max size - 5 mb")
    ));

    if ($post->validate()) {


        $var = array(

            array(
                "c" => "m_",
                "size" => array("w" => 150, "h" => 150)
            ),
            array(
                "c" => "p_",
                "size" => array("w" => 500, "h" => 500)
            )

        );

        $file = $post->_files['files'];

        foreach ($var as $item) {

            $width = $item['size']['w'];
            $height = $item['size']['h'];

            $k = $width / $height;

            $image = new Image();
            $image->load($uploadPath . '/' . $file['name']);

            $Width = $image->getImageWidth();
            $Height = $image->getImageHeight();

            $K = $Width / $Height;

            if ($k == $K) {

                $image->resize($width, $height);
                $image->save($uploadPath . '/' . $item['c'] . $file['name']);

            } elseif ($k < $K) { //  ширина больше высоты

                $Width_new = ($Width / $Height) * $width;
                $image->resize($Width_new, $height);

                $x = ($Width_new - $width) / 2;
                $y = 0;

                $image->crop($width, $height, $x, $y);
                $image->save($uploadPath . '/' . $item['c'] . $file['name']);

            } else { // высота больше ширины

                $Height_new = ($Height / $Width) * $height;

                $image->resize($width, $Height_new);

                $x = 0;
                $y = ($Height_new - $height) / 2;

                $image->crop($width, $height, $x, $y);
                $image->save($uploadPath . '/' . $item['c'] . $file['name']);

            }

        }

        $image = new Image();

        $image->load($uploadPath . '/' . $file['name']);
        $image->save($uploadPath . '/' . $file['name']);


        echo json_encode(array("status" => "success", "info" => $uploadDir . '/' . $file['name']));

    } else {

        echo "valid_error";

    }

})->condition(array('id' => 'int'));

$app->ajax('/admin/vendors/ajax/editInfo', function () use ($app) {
    /**
     * @var int $id
     * @var string $name
     * @var string $value
     * @var Admin $admin
     */
    session_start();

    $post = new Post(array('value'));

    $post->addRule('id', array('required' => array("")));
    $post->addRule('name', array('required' => array("")));
    $post->addRule('value', array('required' => array("")));

    extract($post->getValues());

    if ($post->validate()) {

        $admin = $app->getModule('admin', 'admin', false, array($app));

        if (!$admin->isLogin()) {
            die();
        }

        if ($admin->editInfo($id, $name, $value)) {

            echo json_encode(array("status" => "success", "text" => $value));

        } else {

            echo 'error';

        }

    } else {

        echo json_encode(['status' => 'fail', "text" => $value]);

    }

});

$app->ajax('/admin/vendors/ajax/addGallery/:id', function ($id) use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post();

    $uploadDir = '/uploads/vendors/' . $id;
    $uploadPath = './uploads/vendors/' . $id;

    $post->addFile("files", $uploadPath, array('required' => array("Upload file for continue"),
        'validExtensions' => array(array("jpg", "jpeg", "bmp", "png"), "File extension is not valid"),
        'maxSize' => array(5, "Max size - 5 mb")
    ));

    if ($post->validate()) {

        $var = array(

            array(
                "c" => "m_",
                "size" => array("w" => 150, "h" => 150)
            ),
            array(
                "c" => "p_",
                "size" => array("w" => 500, "h" => 500)
            )

        );

        $file = $post->_files['files'];

        foreach ($var as $item) {

            $width = $item['size']['w'];
            $height = $item['size']['h'];

            $k = $width / $height;

            $image = new Image();
            $image->load($uploadPath . '/' . $file['name']);

            $Width = $image->getImageWidth();
            $Height = $image->getImageHeight();

            $K = $Width / $Height;

            if ($k == $K) {

                $image->resize($width, $height);
                $image->save($uploadPath . '/' . $item['c'] . $file['name']);

            } elseif ($k < $K) { //  ширина больше высоты

                $Width_new = ($Width / $Height) * $width;
                $image->resize($Width_new, $height);

                $x = ($Width_new - $width) / 2;
                $y = 0;

                $image->crop($width, $height, $x, $y);
                $image->save($uploadPath . '/' . $item['c'] . $file['name']);

            } else { // высота больше ширины

                $Height_new = ($Height / $Width) * $height;

                $image->resize($width, $Height_new);

                $x = 0;
                $y = ($Height_new - $height) / 2;

                $image->crop($width, $height, $x, $y);
                $image->save($uploadPath . '/' . $item['c'] . $file['name']);

            }

        }

        $image = new Image();

        $image->load($uploadPath . '/' . $file['name']);
        $image->save($uploadPath . '/' . $file['name']);

        $admin->addGallery($id, $file['name']);

        echo json_encode(array("status" => "success", "src" => $uploadDir . '/' . $file['name'], 'm_src' => $uploadDir . '/' . 'p_' . $file['name']));

    } else {

        echo "valid_error";

    }

})->condition(array('id' => 'int'));

$app->ajax('/admin/vendors/ajax/addLogo/:id', function ($id) use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post();

    $uploadDir = '/uploads/vendors/' . $id;
    $uploadPath = './uploads/vendors/' . $id;

    $post->addFile("files", $uploadPath, array('required' => array("Upload file for continue"),
        'validExtensions' => array(array("jpg", "jpeg", "bmp", "png"), "File extension is not valid"),
        'maxSize' => array(5, "Max size - 5 mb")
    ));

    if ($post->validate()) {

        $var = array(

            array(
                "c" => "m_",
                "size" => array("w" => 150, "h" => 150)
            ),
            array(
                "c" => "p_",
                "size" => array("w" => 500, "h" => 500)
            )

        );

        $file = $post->_files['files'];

        foreach ($var as $item) {

            $width = $item['size']['w'];
            $height = $item['size']['h'];

            $k = $width / $height;

            $image = new Image();
            $image->load($uploadPath . '/' . $file['name']);

            $Width = $image->getImageWidth();
            $Height = $image->getImageHeight();

            $K = $Width / $Height;

            if ($k == $K) {

                $image->resize($width, $height);
                $image->save($uploadPath . '/' . $item['c'] . $file['name']);

            } elseif ($k < $K) { //  ширина больше высоты

                $Width_new = ($Width / $Height) * $width;
                $image->resize($Width_new, $height);

                $x = ($Width_new - $width) / 2;
                $y = 0;

                $image->crop($width, $height, $x, $y);
                $image->save($uploadPath . '/' . $item['c'] . $file['name']);

            } else { // высота больше ширины

                $Height_new = ($Height / $Width) * $height;

                $image->resize($width, $Height_new);

                $x = 0;
                $y = ($Height_new - $height) / 2;

                $image->crop($width, $height, $x, $y);
                $image->save($uploadPath . '/' . $item['c'] . $file['name']);

            }

        }

        $image = new Image();

        $image->load($uploadPath . '/' . $file['name']);
        $image->save($uploadPath . '/' . $file['name']);

        $admin->addLogo($id, $file['name']);

        echo json_encode(array("status" => "success", "src" => $uploadDir . '/' . $file['name']));

    } else {

        echo "valid_error";

    }

})->condition(array('id' => 'int'));

$app->ajax('/admin/vendors/ajax/deleteGallery/:id', function ($id) use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $src = explode('/', $_POST['src']);
    $src = substr(end($src), 2);

    if (isset ($_POST['logo']) && $_POST['logo']) {

        $res = $admin->deleteLogo($id);

    } else {

        $res = $admin->deleteGallery($id, $src);

        if (!$res) {

            $res = $admin->deletePromGallery($src);

        }

    }

    if ($res) {

        if (unlink('./uploads/vendors/' . $id . '/' . $src)) {

            unlink('./uploads/vendors/' . $id . '/' . 'm_' . $src);
            unlink('./uploads/vendors/' . $id . '/' . 'p_' . $src);

            echo json_encode(array('status' => 'success'));

        } else {

            echo json_encode(array('status' => "fail"));

        }

    } else {

        echo json_encode(array('status' => "fail_delete"));

    }

})->condition(array('id' => 'int'));

$app->ajax('/admin/vendors/ajax/searchVendorSports/:id', function ($id) use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post();

    $post->addRule('q', array('required' => array("")));

    $data = $post->getValues();

    if ($post->validate()) {

        if ($res = $admin->vendorsSportsSearch($id, $data['q'])) {

            echo json_encode(array("status" => 'success', 'elements' => $res));

        } else {

            echo json_encode(array("status" => 'fail'));

        }

    } else {

        echo json_encode(array("status" => 'success', 'elements' => $admin->getSportsToVendor($id)));

    }

});

$app->ajax('/admin/vendors/ajax/addPromImg/:id/:sport_id', function ($id, $sport_id) use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $uploadDir = '/uploads/vendors/' . $id;
    $uploadPath = './uploads/vendors/' . $id;

    $post = new Post();

    $post->addFile("files", $uploadPath, array('required' => array("Upload file for continue"),
        'validExtensions' => array(array("jpg", "jpeg", "bmp", "png"), "File extension is not valid"),
        'maxSize' => array(5, "Max size - 5 mb")
    ));

    if ($post->validate()) {


        $var = array(

            array(
                "c" => "m_",
                "size" => array("w" => 150, "h" => 150)
            ),
            array(
                "c" => "p_",
                "size" => array("w" => 500, "h" => 500)
            )

        );

        $file = $post->_files['files'];

        foreach ($var as $item) {

            $width = $item['size']['w'];
            $height = $item['size']['h'];

            $k = $width / $height;

            $image = new Image();
            $image->load($uploadPath . '/' . $file['name']);

            $Width = $image->getImageWidth();
            $Height = $image->getImageHeight();

            $K = $Width / $Height;

            if ($k == $K) {

                $image->resize($width, $height);
                $image->save($uploadPath . '/' . $item['c'] . $file['name']);

            } elseif ($k < $K) { //  ширина больше высоты

                $Width_new = ($Width / $Height) * $width;
                $image->resize($Width_new, $height);

                $x = ($Width_new - $width) / 2;
                $y = 0;

                $image->crop($width, $height, $x, $y);
                $image->save($uploadPath . '/' . $item['c'] . $file['name']);

            } else { // высота больше ширины

                $Height_new = ($Height / $Width) * $height;

                $image->resize($width, $Height_new);

                $x = 0;
                $y = ($Height_new - $height) / 2;

                $image->crop($width, $height, $x, $y);
                $image->save($uploadPath . '/' . $item['c'] . $file['name']);

            }

        }

        $image = new Image();

        $image->load($uploadPath . '/' . $file['name']);
        $image->save($uploadPath . '/' . $file['name']);


        $id = $admin->addPromImg($id, $sport_id, $file['name']);

        echo json_encode(array("status" => "success", "src" => $uploadDir . '/' . $file['name'], 'id' => $id));

    } else {

        echo "valid_error";

    }

})->condition(array('id' => 'int'));

$app->ajax('/admin/vendors/ajax/updatePromImg/:id', function ($id) use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $prom_info = $admin->getPromotionInfo($id);

    $uploadPath = './uploads/vendors/' . $prom_info['vendor_id'];

    $post = new Post();

    $post->addFile("files", $uploadPath, array('required' => array("Upload file for continue"),
        'validExtensions' => array(array("jpg", "jpeg", "bmp", "png"), "File extension is not valid"),
        'maxSize' => array(5, "Max size - 5 mb")
    ));

    if ($post->validate()) {


        $var = array(

            array(
                "c" => "m_",
                "size" => array("w" => 150, "h" => 150)
            ),
            array(
                "c" => "p_",
                "size" => array("w" => 500, "h" => 500)
            )

        );

        $file = $post->_files['files'];

        foreach ($var as $item) {

            $width = $item['size']['w'];
            $height = $item['size']['h'];

            $k = $width / $height;

            $image = new Image();
            $image->load($uploadPath . '/' . $file['name']);

            $Width = $image->getImageWidth();
            $Height = $image->getImageHeight();

            $K = $Width / $Height;

            if ($k == $K) {

                $image->resize($width, $height);
                $image->save($uploadPath . '/' . $item['c'] . $file['name']);

            } elseif ($k < $K) { //  ширина больше высоты

                $Width_new = ($Width / $Height) * $width;
                $image->resize($Width_new, $height);

                $x = ($Width_new - $width) / 2;
                $y = 0;

                $image->crop($width, $height, $x, $y);
                $image->save($uploadPath . '/' . $item['c'] . $file['name']);

            } else { // высота больше ширины

                $Height_new = ($Height / $Width) * $height;

                $image->resize($width, $Height_new);

                $x = 0;
                $y = ($Height_new - $height) / 2;

                $image->crop($width, $height, $x, $y);
                $image->save($uploadPath . '/' . $item['c'] . $file['name']);

            }

        }

        $image = new Image();

        $image->load($uploadPath . '/' . $file['name']);
        $image->save($uploadPath . '/' . $file['name']);


        if ($admin->updatePromImg($file['name'], $id)) {

            echo json_encode(array("status" => "success", "src" => '/uploads/vendors/' . $prom_info['vendor_id'] . '/' . $file['name']));

        } else {

            echo json_encode(array("status" => "fail"));

        }

    } else {

        echo "valid_error";

    }

})->condition(array('id' => 'int'));

$app->ajax('/admin/vendors/ajax/setPromImgFromGalerry', function () use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post();

    $post->addRule('src', array('required' => array("")));

    if ($post->validate()) {

        $data = $post->getValues();
        $src = explode('/', $data['src']);
        $src = end($src);

        if (isset ($data['prom_id'])) {

            $prom_info = $admin->getPromotionInfo($data['prom_id']);

            if ($admin->updatePromImg($src, $data['prom_id'])) {

                echo json_encode(array("status" => "success", "src" => '/uploads/vendors/' . $prom_info['vendor_id'] . '/' . $src));

            } else {

                echo json_encode(array("status" => "fail"));

            }

        } else {

            if ($id = $admin->addPromImg($data['id'], $data['sport_id'], $src)) {

                echo json_encode(array("status" => "success", "src" => '/uploads/vendors/' . $data['id'] . '/' . $src, 'id' => $id));

            } else {

                echo json_encode(array("status" => "fail"));

            }

        }

    } else {

        echo 'valid_error';

    }

});

$app->ajax('/admin/vendors/ajax/editPromoInfo/:id', function ($id) use ($app) {

    /**
     * @var string $name
     * @var string $value
     * @var Admin $admin
     */

    if ($_POST['name'] == 'id') { // ибо нефог id менять

        die();

    }

    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post(['f_desc']);

    $post->addRule('name', array('required' => array("")));
    $post->addRule('value', array('required' => array("")));

    extract($post->getValues());

    if ($post->validate()) {

        if ($admin->updatePromoInfo($id, $name, $value)) {

            echo json_encode(array("status" => "success", "text" => $value));

        } else {

            echo 'error';

        }

    } else {

        echo json_encode(array("status" => "fail", "text" => $value));

    }

})->condition(array('id' => 'int'));

$app->ajax('/admin/vendors/ajax/addPromInfo/:vendor_id/:sport_id',
    function ($vendor_id, $sport_id) use ($app) {

        /**
         * @var string $name
         * @var string $value
         * @var Admin $admin
         */

        if ($_POST['name'] == 'id') { // ибо нефог id менять

            die();

        }

        session_start();

        $admin = $app->getModule('admin', 'admin', false, array($app));

        if (!$admin->isLogin()) {
            die();
        }

        $post = new Post();

        $post->addRule('name', array('required' => array("")));
        $post->addRule('value', array('required' => array("")));

        if ($post->validate()) {

            extract($post->getValues());

            if ($id = $admin->addPromInfo($vendor_id, $sport_id, $name, $value)) {

                echo json_encode(array("status" => "success", "text" => $value, "id" => $id));

            } else {

                echo 'error';

            }

        } else {

            echo 'valid_error';

        }

    })->condition(array('vendor_id' => 'int', 'sport_id' => 'int'));

$app->ajax('/admin/vendors/ajax/getPromInfo/:id', function ($id) use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post();

    $data = $post->getValues();

    if ($res = $admin->getPromotionInfo($id)) {

        if (isset ($data['key'])) {

            echo json_encode([
                "status" => "success",
                "res" => [
                    'data' => $res[$data['key']],
                    'edit' => $admin->dbRead->select("SELECT 1 FROM promotion_edit WHERE prom_id = :id AND {$data['key']} = '1'", ['id' => $id]) ? 'true' : 'false',
                ]
            ]);

        } else {

            echo json_encode([
                "status" => "success",
                "res" => $res
            ]);

        }

    } else {

        echo json_encode(array("status" => "fail"));

    }

})->condition(array('id' => 'int'));

$app->ajax('/admin/vendors/ajax/getPromPrice/:id', function ($id) use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    if ($res = $admin->getPromPrice($id)) {

        echo json_encode(array('status' => 'success', 'data' => $res));

    } else {

        echo json_encode(array('status' => 'fail'));

    }

})->condition(array('id' => 'int'));

$app->ajax('/admin/vendors/ajax/addMark/:id/:name/:location', function ($id, $name, $location) use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $name = urldecode($name);
    $location = urldecode($location);

    $loc_coord = explode(',', preg_replace('/[\(\) ]/i', '', $location));

    if ($id = $admin->promAddMark($id, $name, $loc_coord)) {

        echo json_encode(array('status' => 'success', 'id' => $id));

    } else {

        echo json_encode(array('status' => 'fail'));

    }

});

$app->ajax('/admin/vendors/ajax/getPromMaps/:id', function ($id) use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    if ($res = $admin->getPromMarks($id)) {

        echo json_encode(array('status' => 'success', 'data' => $res));

    } else {

        echo json_encode(array('status' => 'fail'));

    }

})->condition(array('id' => 'int'));

$app->ajax('/admin/vendors/ajax/deletePromMap/:id', function ($id) use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    if ($admin->deletePromMap($id)) {

        echo json_encode(array('status' => 'success'));

    } else {

        echo json_encode(array('status' => 'fail'));

    }

})->condition(array('id' => 'int'));

$app->ajax('/admin/vendors/ajax/editPromAges/:id', function ($id) use ($app) {
    /**
     * @var string $name
     * @var string $value
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post ();

    $post->addRule('name', array('required' => array("")));
    $post->addRule('value', array('required' => array("")));

    if ($post->validate()) {

        extract($post->getValues());

        if ($admin->editAges($name, $value, $id)) {

            echo json_encode(array('status' => 'success'));

        } else {

            echo json_encode(array('status' => 'fail'));

        }

    } else {

        echo json_encode(array('status' => 'fail', 'text' => ''));

    }

})->condition(array('id' => 'int'));

$app->ajax('/admin/vendors/ajax/editPromCat/:id', function ($id) use ($app) {

    /**
     * @var string $status
     * @var string $value
     * @var Admin $admin
     */

    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post ();

    $post->addRule('status', array('required' => array("")));
    $post->addRule('value', array('required' => array("")));

    if ($post->validate()) {

        extract($post->getValues());

        if ($data = $admin->editCat($status, $value, $id)) {

            echo json_encode(array('status' => 'success', 'data' => $data));

        } else {

            echo json_encode(array('status' => 'fail'));

        }

    } else {

        echo 'valid error';

    }

})->condition(array('id' => 'int'));

$app->ajax('/admin/vendors/ajax/editDay/:id', function ($id) use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post ();

    $post->addRule('day', array('required' => array("")));
    $post->addRule('max', array('required' => array("")));
    $post->addRule('min', array('required' => array("")));

    if ($post->validate()) {

        $data = $post->getValues();

        if (is_array($data['day'])) {

            foreach ($data['day'] as $val) {

                $admin->editPromDay($val, $data['max'], $data['min'], $id);

            }

        } else {

            $admin->editPromDay($data['day'], $data['max'], $data['min'], $id);

        }

    } else {

        echo 'valid error';

    }

})->condition(array('id' => 'int'));

$app->ajax('/admin/vendors/ajax/editPromGolden/:id', function ($id) use ($app) {

    /**
     * @var $status
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post ();

    $post->addRule('status', array('required' => array("")));

    if ($post->validate()) {

        extract($post->getValues());

        echo json_encode(array('status' => ($admin->editGolden(($status == 'true' ? 1 : 0), $id) ? "success" : "fail")));

    } else {

        echo 'valid error';

    }

})->condition(array('id' => 'int'));

$app->ajax('/admin/vendors/ajax/editPromGender/:id', function ($id) use ($app) {

    /**
     * @var $val
     * @var Admin $admin
     */

    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post ();

    $post->addRule('val', array('required' => array("")));

    if ($post->validate()) {

        extract($post->getValues());

        echo json_encode(array('status' => ($admin->editGender($val, $id) ? "success" : "fail")));

    } else {

        echo 'valid error';

    }

})->condition(array('id' => 'int'));

$app->ajax('/admin/vendors/ajax/getAllMap/:v_id/:s_id/:p_id',
    function ($v_id, $s_id, $p_id) use ($app) {
        /**
         * @var Admin $admin
         */
        session_start();

        $admin = $app->getModule('admin', 'admin', false, array($app));

        if (!$admin->isLogin()) {
            die();
        }

        if ($data = $admin->getAllMap($v_id, $s_id, $p_id)) {

            echo json_encode(array('status' => 'success', 'data' => $data));

        } else {

            echo json_encode(array('status' => 'fail'));

        }

    })->condition(array('v_id' => 'int', 's_id' => 'int', 'p_id' => 'int'));

$app->ajax('/admin/vendors/ajax/addPromMark/:id', function ($id) use ($app) {

    /**
     * @var $map
     * @var Admin $admin
     */

    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post ();

    $post->addRule('map', array('required' => array("")));

    if ($post->validate()) {

        extract($post->getValues());

        if ($data = $admin->addPromMark($id, $map)) {

            echo json_encode(array('status' => 'success', 'data' => $data));

        } else {

            echo json_encode(array('status' => 'fail'));

        }

    } else {

        echo 'valid error';

    }

})->condition(array('id' => 'int'));

$app->ajax('/admin/vendors/ajax/getAllMaps', function () use ($app) {

    /**
     * @var $v_id
     * @var $s_id
     * @var Admin $admin
     */

    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post();

    $post->addRule('v_id', array('required' => array("")));
    $post->addRule('s_id', array('required' => array("")));

    if ($post->validate()) {

        extract($post->getValues());

        if ($data = $admin->getAllMaps($v_id, $s_id)) {

            echo json_encode(array('status' => 'success', 'data' => $data));

        } else {

            echo json_encode(array('status' => 'fail'));

        }

    } else {

        echo 'valid_error';

    }

});

$app->ajax('/admin/vendors/ajax/deletePromotion/:id', function ($id) use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    if ($data = $admin->deletePromotion($id)) {

        echo json_encode(array('status' => 'success', 'data' => $data));

    } else {

        echo json_encode(array('status' => 'fail'));

    }

})->condition(array('id' => 'int'));

$app->ajax('/admin/vendors/ajax/deleteSport/:id/:sport_id', function ($id, $sport_id) use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    if ($data = $admin->deleteSports($id, $sport_id)) {

        echo json_encode(array('status' => 'success', 'data' => $data));

    } else {

        echo json_encode(array('status' => 'fail'));

    }

})->condition(array('id' => 'int', 'sport_id' => 'int'));

$app->ajax('/admin/vendors/ajax/deletePrice', function () use ($app) {

    /**
     * @var int $id
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post();

    $post->addRule('id', array('required' => array("")));

    if ($post->validate()) {

        extract($post->getValues());

        if ($admin->deletePrice($id)) {

            echo json_encode(array('status' => 'success'));

        } else {

            echo json_encode(array('status' => 'fail'));

        }

    } else {

        echo 'valid_error';

    }

});

$app->ajax('/admin/vendors/ajax/addPromGallery/:id/:v_id', function ($id, $v_id) use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post();

    $uploadDir = '/uploads/vendors/' . $v_id;
    $uploadPath = './uploads/vendors/' . $v_id;

    $post->addFile("files", $uploadPath, array('required' => array("Upload file for continue"),
        'validExtensions' => array(array("jpg", "jpeg", "bmp", "png"), "File extension is not valid"),
        'maxSize' => array(5, "Max size - 5 mb")
    ));

    if ($post->validate()) {

        $var = array(

            array(
                "c" => "m_",
                "size" => array("w" => 150, "h" => 150)
            ),
            array(
                "c" => "p_",
                "size" => array("w" => 500, "h" => 500)
            )

        );

        $file = $post->_files['files'];

        foreach ($var as $item) {

            $width = $item['size']['w'];
            $height = $item['size']['h'];

            $k = $width / $height;

            $image = new Image();
            $image->load($uploadPath . '/' . $file['name']);

            $Width = $image->getImageWidth();
            $Height = $image->getImageHeight();

            $K = $Width / $Height;

            if ($k == $K) {

                $image->resize($width, $height);
                $image->save($uploadPath . '/' . $item['c'] . $file['name']);

            } elseif ($k < $K) { //  ширина больше высоты

                $Width_new = ($Width / $Height) * $width;
                $image->resize($Width_new, $height);

                $x = ($Width_new - $width) / 2;
                $y = 0;

                $image->crop($width, $height, $x, $y);
                $image->save($uploadPath . '/' . $item['c'] . $file['name']);

            } else { // высота больше ширины

                $Height_new = ($Height / $Width) * $height;

                $image->resize($width, $Height_new);

                $x = 0;
                $y = ($Height_new - $height) / 2;

                $image->crop($width, $height, $x, $y);
                $image->save($uploadPath . '/' . $item['c'] . $file['name']);

            }

        }

        $image = new Image();

        $image->load($uploadPath . '/' . $file['name']);
        $image->save($uploadPath . '/' . $file['name']);

        $admin->addPromGallery($file['name'], $id);

        echo json_encode(array("status" => "success", "id" => $id, "src" => $uploadDir . '/p_' . $file['name'], 'original' => $uploadDir . '/' . $file['name']));

    } else {

        echo "valid_error";

    }

})->condition(['id' => 'int']);

$app->ajax('/admin/vendors/ajax/getPromGallery', function () use ($app) {

    /**
     * @var int $id
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post();

    $post->addRule('id', array('required' => array("")));

    if ($post->validate()) {

        extract($post->getValues());

        $data = $admin->getPromGallery($id);

        if ($data) {

            echo json_encode(['status' => 'success', 'data' => $data]);

        } else {

            echo json_encode(['status' => 'fail']);

        }

    } else {

        echo 'valid error';

    }

});

$app->ajax('/vendor-cabinet/ajax/deletePrice', function () use ($app) {

    /**
     * @var int $id
     * @var Admin $admin
     */

    session_start();

    $vendor = $app->getModule('vendor', 'main', false, array($app));

    if (!$vendor->isLogin()) {
        die();
    }

    $post = new Post();

    $post->addRule('id', array('required' => array("")));

    if ($post->validate()) {

        extract($post->getValues());

        echo json_encode(['status' => ($vendor->deletePrice($id) ? 'success' : 'fail')]);

    } else {

        echo 'valid error';

    }

});

$app->ajax('/admin/vendors/ajax/addPromotion', function () use ($app) {

    /**
     * @var int $sport_id
     * @var int $id
     * @var Admin $admin
     */

    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post();

    $post->addRule('sport_id', array('required' => array("")));

    if ($post->validate()) {

        extract($post->getValues());

        $info = $admin->createPromotions($sport_id, $id);

        echo json_encode(['status' => ($info ? 'success' : 'fail'), 'info' => $info]);

    }

});

$app->ajax('/admin/vendors/ajax/editEmail', function () use ($app) {

    /**
     * @var int $value
     * @var int $id
     * @var Admin $admin
     */


    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post ();

    $post->addRule('id', array('required' => array("")));
    $post->addRule('value', array('required' => array("")));

    if ($post->validate()) {

        extract($post->getValues());

        if ($admin->editVendorEmail($value, $id)) {

            echo json_encode(['status' => 'success', 'text' => $value]);

        } else {

            echo json_encode(['status' => 'fail', 'text' => '']);

        }

    } else {

        echo json_encode(['status' => 'fail', 'text' => '']);

    }


});

$app->ajax('/admin/vendors/ajax/changeColor', function () use ($app) {

    /**
     * @var string $color
     * @var int $id
     * @var Admin $admin
     */

    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post ();

    $post->addRule('id', array('required' => array("")));
    $post->addRule('color', array('required' => array("")));

    if ($post->validate()) {

        extract($post->getValues());

        if ($admin->changeColor($id, $color)) {

            echo json_encode(['status' => 'success']);

        } else {

            echo json_encode(['status' => 'fail']);

        }

    }

});

$app->ajax('/admin/vendors/ajax/edit/:id', function ($id) use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post ();

    $post->addRule('email', array('required' => array("")));

    if ($post->validate()) {

        $data = $post->getValues();

        if ($admin->editVendor($data, $id)) {

            echo json_encode(['status' => 'ok']);

        } else {

            echo json_encode(['status' => 'fail']);

        }

    } else {

        echo json_encode(['error' => 'valid']);

    }

})->condition(['id' => 'int']);

$app->ajax('/admin/vendors/ajax/addPrice/:id', function ($id) use ($app) {

    /**
     * @var float $standart_price
     * @var float $discount_perc
     * @var float $final_price
     * @var string $description_price
     * @var Admin $admin
     */

    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post();

    $post->addRule('standart_price', array('required' => array("")));
    $post->addRule('final_price', array('required' => array("")));

    if ($post->validate()) {

        extract($post->getValues());

        if ($res = $admin->addPrice($standart_price, $discount_perc, $final_price, $description_price, $id)) {

            echo json_encode($res);

        } else {

            echo json_encode(['status' => 'fail']);

        }

    } else {

        echo 'valid error';

    }

})->condition(['id' => 'int']);

$app->ajax('/admin/vendors/ajax/editPrice/:id', function ($id) use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    $post = new Post();

    $post->addRule('standart_price', array('required' => array("")));
    $post->addRule('discount_perc', array('required' => array("")));
    $post->addRule('final_price', array('required' => array("")));

    if ($post->validate()) {

        $data = $post->getValues();

        if ($data = $admin->editPrice($id, $data)) {

            echo json_encode($data);

        } else {

            echo json_encode(['status' => 'fail']);

        }

    } else {

        echo 'valid error';

    }

})->condition(['id' => 'int']);


$app->ajax('/admin/vendors/ajax/getPrice/:id', function ($id) use ($app) {
    /**
     * @var Admin $admin
     */
    session_start();

    $admin = $app->getModule('admin', 'admin', false, array($app));

    if (!$admin->isLogin()) {
        die();
    }

    echo json_encode($admin->getPrice($id));

})->condition(['id' => 'int']);