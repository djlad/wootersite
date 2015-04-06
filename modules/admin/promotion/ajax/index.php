a<?

$app->ajax('/admin/promotion/ajax/delete', function () use ($app) {

    /**
     * @var Admin $admin
     */

    session_start();

    $post = new Post();

    $post->addRule('act', array('required' => array("")));
    $post->addRule('id', array('required' => array("")));

    if ($post->validate()) {

        $admin = $app->getModule('admin', 'admin', false, array($app));

        if (!$admin->isLogin()) {
            die();
        }

        $data = $post->getValues();

        $info = $admin->getInfoByPromotion($data['id']);

        if ($admin->deleteVendorSport($info['vendor_id'], $info['sport_id'])) {

            echo json_encode(array("status" => 'ok'));

        } else {

            echo json_encode(array("status" => 'fail'));

        }

    } else {

        echo "valid_error";

    }
});