<?

/**
 * Class Admin
 */
class Admin
{

    private $idObject;
    private $error = [];
    private $fields = [
        'empty' => 0,
        'count' => 0,
    ];

    /**
     * @param $app
     */
    public function __construct($app)
    {

        $this->app = $app;
        $this->dbRead = db::getInstance('read');
        $this->dbWrite = db::getInstance('write');
    }

    /**
     * @return bool
     */
    public function isLogin()
    {

        return isset ($_SESSION['admin_id']) ? $this->id = $_SESSION['admin_id'] : false;

    }

    /**
     * @param $login
     * @param $pswd
     * @return bool
     * @throws Exception
     */
    public function login($login, $pswd)
    {

        $res = $this->dbRead->select("SELECT id, pswd, salt FROM admin WHERE login = :login", array('login' => $login));

        if ($res) {

            $res = $res[0];

            $pswd = md5(sha1($pswd) . $res['salt']);

            if ($pswd === $res['pswd']) {

                return $res['id'];

            } else {

                return false;

            }

        } else {

            return false;

        }

    }

    /**
     * @param bool $req
     * @return array
     * @throws Exception
     */
    public function getAdminMenu($req = false)
    {

        if ($req === false) {
            $req = $_SERVER['REQUEST_URI'];
        }

        $menu = array();

        $res = $this->dbRead->select("SELECT * FROM admin_menu WHERE pid = '0' AND display = '1' ORDER BY listorder ASC");

        foreach ($res as $key => $value) {

            $menu[$value['id']] = array(
                "name" => $value['name'],
                "selected" => $this->isMenuSelected($value['link'], $req),
                "link" => ADMIN_PATH . ($value['link'] ? '/' . $value['link'] : ''),
                "icon" => $value['icon'], "hasSub" => false,
                "submenu" => ''
            );

            $pid = $value['id'];

            $r = $this->dbRead->select("SELECT * FROM admin_menu WHERE pid = '$pid' AND display = '1'  ORDER BY listorder ASC");

            if (count($r) > 0) {

                $menu[$value['id']]['hasSub'] = true;

                foreach ($r as $k => $v) {

                    $selected = $this->isMenuSelected($v['link'], $req);

                    $menu[$value['id']]['submenu'][] = array("name" => $v['name'], "selected" => $selected, "link" => ADMIN_PATH . '/' . $v['link']);

                    if ($selected) {

                        $menu[$value['id']]['selected'] = true;

                    }

                }

            }

        }

        return $menu;

    }

    /**
     * @param $link
     * @param $url
     * @return bool
     */
    public function isMenuSelected($link, $url)
    {

        $uri = preg_replace('`^admin/(?=.+)|admin$`', '', trim($url, '/'));

        $link = trim($link, '/');

        return $uri == $link;

    }

    public function editPswd($pswd)
    {

        $salt = Encryption::generateRandomKey(5);

        $pswd = md5(sha1($pswd) . $salt);

        return $this->dbWrite->update("admin", array("pswd" => $pswd, "salt" => $salt), "id={$this->id}");

    }


    public function getUsers()
    {

        return $this->dbRead->select("SELECT u.id, u.email, DATE_FORMAT(u.cdate, '%m-%d-%Y') as cdate, ui.first_name, ui.last_name, ui.code
																FROM user as u 
																INNER JOIN user_info as ui 
																ON (u.id = ui.user_id)");

    }

    public function getUser($id)
    {

        $res = $this->dbRead->select("SELECT u.id, u.email, DATE_FORMAT(u.cdate, '%m-%d-%Y') as cdate, ui.first_name, ui.last_name, ui.code
																FROM user as u 
																INNER JOIN user_info as ui 
																ON (u.id = ui.user_id)
																WHERE u.id=:id", array('id' => $id));

        if ($res) {

            return $res[0];

        } else {

            return false;

        }

    }

    public function deleteUser($id)
    {

        if ($this->dbWrite->delete('user', "id='$id'")) {

            if ($this->dbWrite->delete('user_info', "user_id='$id'")) {

                return true;

            } else {

                return false;

            }

        } else {

            return false;

        }

    }

    public function addUser($data)
    {

        $salt = Encryption::generateRandomKey(5);

        $data['pswd'] = md5(sha1($salt) . md5($data['pswd']));

        if ($this->dbWrite->insert("user", $this->dbRead->getTableFields('user', $data, array('id')))) {

            $data['user_id'] = $this->dbRead->lastInsertId();

            if ($this->dbWrite->insert("user_info", $this->dbRead->getTableFields('user_info', $data, array()))) {

                return true;

            } else {

                return false;

            }

        } else {

            return false;

        }

    }

    public function addVendor($data)
    {

        $salt = Encryption::generateRandomKey(5);

        $data['pswd'] = md5(sha1($salt) . md5($data['pswd']));
        $data['salt'] = $salt;

        if ($this->dbWrite->insert("vendor", $this->dbRead->getTableFields('vendor', array_merge($data, array('valid' => 1)), array('id')))) {

            $id = $this->dbRead->lastInsertId();

            $this->dbWrite->insert("section_edit", ['vendor_id' => $id]);

            $data['vendor_id'] = $id;

            $res = $this->dbWrite->insert("section", $this->dbRead->getTableFields('section', $data, ['id']));

            return $res ? $id : false;

        } else {

            return false;

        }

    }

    public function getVendors($by, $order)
    {

        $by = (!empty($by)) ? $by : 'u.id';
        $order = (!empty($order)) ? $order : 'asc';

        if ($by == 'color') {

            if ($order == 'desc') {

                $by = "color = 'green', color = 'yellow', color = 'red'";

            } else {

                $by = "color = 'red', color = 'yellow', color = 'green'";

            }

            $order = '';

        }

        return $this->dbRead->select("SELECT
											u.id, u.email, 
											DATE_FORMAT(u.cdate, '%m-%d-%Y') as cdate, 
											u.phone_number,
											s.name as company_name,
											s.modified,
											s.address,
											s.percent,
											s.color,
											(SELECT COUNT(DISTINCT sport_id) FROM promotion as p WHERE p.vendor_id = u.id) as sport_count,
											(SELECT COUNT(`id`) FROM promotion WHERE vendor_id = u.id) as prom_count
										FROM 
											vendor as u 
										LEFT JOIN
											section as s
										ON 
											(s.vendor_id = u.id)
										ORDER BY {$by} {$order}");

    }

    public function getVendor($id)
    {

        $res = $this->dbRead->select("SELECT
												u.id, u.email,
												DATE_FORMAT(u.cdate, '%m-%d-%Y') as cdate,
												u.phone_number,
												s.name as company_name
											FROM 
												vendor as u 
											INNER JOIN 
												section as s
											ON 
												(s.vendor_id = u.id)	
											WHERE 
												u.id=:id", array('id' => $id));

        if ($res) {

            return $res[0];

        } else {

            return false;

        }

    }

    public function deleteVendor($id)
    {

        if ($this->dbWrite->delete('vendor', "id='$id'")) {

            $this->dbWrite->query("DELETE FROM promotion WHERE vendor_id NOT IN (SELECT id FROM vendor)");
            $this->dbWrite->query("DELETE FROM section WHERE vendor_id NOT IN (SELECT id FROM vendor)");
            $this->dbWrite->query("DELETE FROM schedule WHERE p_id NOT IN (SELECT id FROM promotion)");
            $this->dbWrite->query("DELETE FROM prices WHERE promotion_id NOT IN (SELECT id FROM promotion)");
            $this->dbWrite->query("DELETE FROM section_edit WHERE vendor_id NOT IN (SELECT id FROM vendor)");
            $this->dbWrite->query("DELETE FROM promotion_edit WHERE prom_id NOT IN (SELECT id FROM promotion)");

            return true;

        } else {

            return false;

        }

    }

    public function addSport($data)
    {

        return $this->dbWrite->insert("sports", $this->dbRead->getTableFields('sports', $data, array('id')));

    }

    public function getAllSports()
    {

        return $this->dbRead->select("SELECT * FROM sports");

    }

    public function deleteSport($id)
    {

        return $this->dbWrite->delete('sports', "id='$id'");

    }

    public function getSports($id)
    {

        $res = $this->dbRead->select("SELECT * FROM sports WHERE id=:id", array('id' => $id));

        if ($res) {

            return $res[0];

        } else {

            return false;

        }

    }

    public function checkSportUrl($url)
    {

        $res = ($this->dbRead->select("SELECT 1 FROM sports WHERE url = :url", array('url' => $url)) ? true : false);

        return $res;

    }

    public function checkSectionUrl($url, $id)
    {

        $res = ($this->dbRead->select("SELECT 1 FROM section WHERE url = :url AND vendor_id!=:id", array('url' => $url, 'id' => $id)) ? true : false);

        return $res;

    }

    public function checkSportUrlDub($id, $url)
    {

        $res = ($this->dbRead->select("SELECT 1 FROM sports WHERE url = :url AND id != :id", array('url' => $url, 'id' => $id)) ? true : false);

        return $res;

    }

    public function editSport($data, $id)
    {

        return $this->dbWrite->update("sports", $this->dbRead->getTableFields('sports', $data, array('id')), "id={$id}");

    }

    public function addSectionInfo($id, $data)
    {

        extract($data);
        $about = addslashes($about);

        (isset($phone_number)) ? $this->dbWrite->update('vendor', array('phone_number' => $phone_number), 'id=' . $id) : '';

        return $this->dbWrite->query("INSERT INTO section (`vendor_id`,`name`,  `image`, `about`, `url`,`link`) VALUES ({$id}, '{$name}',  '{$image}', '{$about}', '{$url}', '{$link}')
													ON DUPLICATE KEY UPDATE `name`='{$name}', `image`='{$image}', `about`='{$about}', `url`='{$url}', `link` = '{$link}' ");

    }

    public function getSectionInfo($id)
    {

        $res = $this->dbRead->select("SELECT * FROM section WHERE vendor_id = :id", array('id' => $id));

        if ($res) {

            return $res[0];

        } else {

            return false;

        }

    }

    public function getSportsToVendor($id)
    {

        return $this->dbRead->select("SELECT id, name FROM sports WHERE id NOT IN (SELECT sport_id FROM promotion WHERE vendor_id = :id ) ORDER BY name ASC", array('id' => $id));

    }

    public function getVendorSports($id)
    {

        return $this->dbRead->select("SELECT s.name, s.id FROM promotion as vs INNER JOIN sports as s  ON (s.id = vs.sport_id) WHERE vs.vendor_id = :id GROUP BY vs.sport_id ORDER BY s.name ASC", array('id' => $id));

    }

    public function getSportInfo($id)
    {

        $res = $this->dbRead->select("SELECT * FROM sports WHERE id = :id", array('id' => $id));

        if ($res) {

            return $res[0];

        } else {

            return false;

        }

    }

    public function addSportInfo($data)
    {

        $res = false;

        if (isset ($data['geo']) && $data['geo']) {

            $geo = explode(",", $data['geo']);

            $geo_x = trim($geo[0], "(");
            $geo_y = trim(trim($geo[1]), ")");

        } else {

            $geo_x = 0;
            $geo_y = 0;

        }

        if ($res = $this->dbWrite->insert("vendors_sports", $this->dbRead->getTableFields('vendors_sports', array_merge($data, array("geo_x" => $geo_x, "geo_y" => $geo_y)), array()))) {

            if (isset ($data['promotion'])) {

                foreach ($data['promotion'] as $val) {

                    $res = $this->dbWrite->insert("promotion", array_merge($this->dbRead->getTableFields('promotion', array_merge($val, array('valid' => 1)), array()), array('vendor_id' => $data['vendor_id'], 'sport_id' => $data['sport_id'])));

                    $promotion_id = $this->dbRead->lastInsertId();

                    if (isset ($val['price'])) {

                        foreach ($val['price'] as $v) {

                            $res = $this->dbWrite->insert('prices', array_merge($this->dbRead->getTableFields('prices', $v, array()), array('vendor_id' => $data['vendor_id'], 'sport_id' => $data['sport_id'], 'promotion_id' => $promotion_id)));

                        }

                    }

                    if (isset ($val ['schedule'])) {

                        foreach ($val['schedule'] as $k => $d) {

                            $res = $this->dbWrite->insert('schedule', array('p_id' => $promotion_id, 'day' => $k, 'time_min' => $d['time_min'], 'time_max' => $d['time_max']));

                        }

                    }

                }

            }

        } else {

            return false;

        }

        return $res;

    }

    public function getVendorSportInfo($id_vendor, $id_sport)
    {

        $res = $this->dbRead->select("SELECT image, about, geo_x, geo_y FROM vendors_sports WHERE sport_id = :sport AND vendor_id = :vendor", array('sport' => $id_sport, 'vendor' => $id_vendor));

        if ($res) {

            $promotion = $this->dbRead->select("SELECT * FROM promotion WHERE vendor_id = :vendor AND sport_id = :sport", array('sport' => $id_sport, 'vendor' => $id_vendor));

            if ($promotion) {


                foreach ($promotion as $k => $p) {

                    $price = $this->dbRead->select("SELECT * FROM prices WHERE vendor_id = :vendor AND sport_id = :sport AND promotion_id = :promotion", array('sport' => $id_sport, 'vendor' => $id_vendor, 'promotion' => $p['id']));

                    $promotion[$k]['price'] = $price ? $price : false;

                    $schedule = $this->dbRead->select("SELECT * FROM schedule WHERE p_id = :id", array('id' => $p['id']));

                    $days = false;

                    if ($schedule) {

                        foreach ($schedule as $day) {

                            $days[$day['day']] = array('time_min' => $day['time_min'], 'time_max' => $day['time_max']);

                        }

                    }

                    $promotion [$k]['schedule'] = $days;

                }

                $res[0]['promotion'] = $promotion;

            } else {

                $res[0]['promotion'] = false;

            }

            return $res[0];

        } else {

            return false;

        }

    }

    public function editSportInfo($data)
    {

        $res = false;

        if (isset ($data['geo']) && $data['geo']) {

            $geo = explode(",", $data['geo']);

            $geo_x = trim($geo[0], "(");
            $geo_y = trim(trim($geo[1]), ")");

        } else {

            $geo_x = 0;
            $geo_y = 0;

        }

        if ($res = $this->dbWrite->update("vendors_sports", $this->dbRead->getTableFields('vendors_sports', array_merge($data, array("geo_x" => $geo_x, "geo_y" => $geo_y)), array()), "sport_id={$data['sport_id']} AND vendor_id={$data['vendor_id']}")) {

            $this->dbWrite->delete("promotion", "sport_id={$data['sport_id']} AND vendor_id={$data['vendor_id']}");
            $this->dbWrite->delete("prices", "sport_id={$data['sport_id']} AND vendor_id={$data['vendor_id']}");
            $this->dbWrite->query("DELETE FROM schedule WHERE p_id NOT IN (SELECT id FROM promotion)");

            if (isset ($data['promotion'])) {

                foreach ($data['promotion'] as $val) {

                    $res = $this->dbWrite->insert("promotion", array_merge($this->dbRead->getTableFields('promotion', array_merge($val, array('valid' => 1)), array()), array('vendor_id' => $data['vendor_id'], 'sport_id' => $data['sport_id'])));

                    $promotion_id = $this->dbRead->lastInsertId();

                    if (isset ($val['price'])) {

                        foreach ($val['price'] as $v) {

                            $res = $this->dbWrite->insert('prices', array_merge($this->dbRead->getTableFields('prices', $v, array()), array('vendor_id' => $data['vendor_id'], 'sport_id' => $data['sport_id'], 'promotion_id' => $promotion_id)));

                        }

                    }

                    if (isset ($val ['schedule'])) {

                        foreach ($val['schedule'] as $k => $d) {

                            $res = $this->dbWrite->insert('schedule', array('p_id' => $promotion_id, 'day' => $k, 'time_min' => $d['time_min'], 'time_max' => $d['time_max']));

                        }

                    }

                }

            }

        } else {

            return false;

        }

        return $res;

    }

    public function deleteVendorSport($id_vendor, $id_sport)
    {

        $res = false;

        $res = $this->dbWrite->delete("promotion", "sport_id={$id_sport} AND vendor_id={$id_vendor}");
        $res = $this->dbWrite->delete("prices", "sport_id={$id_sport} AND vendor_id={$id_vendor}");
        $res = $this->dbWrite->delete("vendors_sports", "sport_id={$id_sport} AND vendor_id={$id_vendor}");

        return $res;

    }

    public function getValidatePromotion()
    {

        return $this->dbRead->select("SELECT * FROM promotion WHERE valid='0'");

    }

    public function getInfoByPromotion($id)
    {

        $res = $this->dbRead->select("SELECT vendor_id, sport_id FROM promotion WHERE id = :id", array('id' => $id));

        $return = ($res) ? $res[0] : false;

        return $return;

    }

    public function getPay()
    {

        return $this->dbRead->select("SELECT
																pay.id as id,
																s.name as company_name,
																sport.name as sport_name,
																prom.name as promotion_name,
																price.name as price_name,
																price.new_price as price,
																u.email as user_email, 
																v.email as vendor_email,
																ui.first_name as user_first_name,
																ui.last_name as user_last_name
															FROM 
																pay as pay
															INNER JOIN section as s
																ON (pay.vendor = s.vendor_id)
															INNER JOIN promotion as prom
																ON (pay.promotion = prom.id)
															INNER JOIN prices as price
																ON (pay.amount_id = price.id)
															INNER JOIN sports as sport
																ON (sport.id = prom.sport_id)
															INNER JOIN user as u
																ON (pay.user = u.id)
															INNER JOIN user_info as ui
																ON (pay.user = ui.user_id)
															INNER JOIN vendor as v
																ON (pay.vendor = v.id)
															WHERE 
																pay.status = '0'
															ORDER BY 
																date ASC");

    }

    public function getPayById($id)
    {

        $res = $this->dbRead->select("SELECT
																pay.id as id,
																s.name as company_name,
																sport.name as sport_name,
																prom.name as promotion_name,
																price.name as price_name,
																price.new_price as price,
																u.email as user_email, 
																v.email as vendor_email,
																ui.first_name as user_first_name,
																ui.last_name as user_last_name
															FROM 
																pay as pay
															INNER JOIN section as s
																ON (pay.vendor = s.vendor_id)
															INNER JOIN promotion as prom
																ON (pay.promotion = prom.id)
															INNER JOIN prices as price
																ON (pay.amount_id = price.id)
															INNER JOIN sports as sport
																ON (sport.id = prom.sport_id)
															INNER JOIN user as u
																ON (pay.user = u.id)
															INNER JOIN user_info as ui
																ON (pay.user = ui.user_id)
															INNER JOIN vendor as v
																ON (pay.vendor = v.id)
															WHERE 
																pay.id = :id
															ORDER BY 
																date ASC", array('id' => $id));

        return ($res ? $res[0] : false);

    }

    public function deletePay($id)
    {

        return $this->dbWrite->delete('pay', 'id=' . $id);

    }

    public function confirmPay($id)
    {

        return $this->dbWrite->update('pay', array('status' => '1'), 'id=' . $id);

    }

    /***/

    public function companyInfo($id)
    {

        $res = $this->dbRead->select("SELECT s.c_email, s.phone_number, s.name, s.about, s.image, s.link, is_golden, v.email
														FROM vendor as v
														INNER JOIN section as s
														ON (v.id = s.vendor_id)
														WHERE v.id = :id", array('id' => $id));

        return ($res ? $res[0] : false);

    }

    public function editInfo($id, $name, $value)
    {

        $this->dbWrite->update('section_edit', [$name => '1'], "vendor_id = {$id}");

        $this->lastModefied($id);

        return $this->dbWrite->update('section', [$name => $value], 'vendor_id = ' . $id);

    }

    public function getVendorGalleryPrev($id)
    {

        return $this->dbRead->select("SELECT * FROM gallery WHERE vendor_id = :id", array('id' => $id));

    }

    public function getVendorGallery($id)
    {

        return $this->dbRead->select("SELECT * FROM gallery WHERE vendor_id = :id", array('id' => $id));

    }

    public function addGallery($id, $name)
    {

        $this->dbWrite->update('section_edit', ['gallery' => '1'], "vendor_id = {$id}");

        $this->dbWrite->insert('gallery', array('vendor_id' => $id, 'src' => $name));

    }

    public function addLogo($id, $name)
    {

        $res = $this->dbRead->select("SELECT image FROM section WHERE vendor_id = :id", array('id' => $id));

        $this->dbWrite->update('section', array('image' => $name), "vendor_id = {$id}");

        $this->dbWrite->update('section_edit', ['logo' => '1'], "vendor_id = {$id}");

        return ($res ? $res[0]['image'] : false);

    }

    public function deleteGallery($id, $src)
    {

        $this->dbWrite->update('promotion', array('img' => ''), "img = '{$src}'");

        return $this->dbWrite->delete('gallery', "src = '{$src}'");

    }

    public function deleteLogo($id)
    {

        return $this->dbWrite->update('section', array('image' => ''), "vendor_id = {$id}");

    }

    public function vendorsSportsSearch($id, $q)
    {

        return $this->dbRead->select("SELECT id, name FROM sports WHERE id NOT IN (SELECT sport_id FROM promotion WHERE vendor_id = :id ) AND name LIKE '" . addslashes(str_replace(array('%', '_'), array('\%', '\_'), $q)) . "%' ORDER BY name ASC", array('id' => $id));

    }

    public function addPromImg($id, $sport_id, $name)
    {

        $this->dbWrite->insert("promotion", array('vendor_id' => $id, 'sport_id' => $sport_id, 'img' => $name));

        return $this->dbRead->lastInsertId();

    }

    public function getVendorPromotion($vendor_id, $sport_id)
    {

        $res = $this->dbRead->select("SELECT * FROM promotion WHERE vendor_id = :vendor_id AND sport_id = :sport_id ORDER BY id", array('vendor_id' => $vendor_id, 'sport_id' => $sport_id));

        if ($res) {

            foreach ($res as $key => $val) {

                $res[$key]['schedule'] = $this->getDays($val['id']);
                $res[$key]['category'] = $this->dbRead->select("SELECT value FROM prom_cat WHERE prom_id = :id", array('id' => $val['id']));
                $res[$key]['gallery'] = $this->dbRead->select("SELECT src, p_id FROM prom_galery WHERE p_id = :id ORDER BY id", ['id' => $val['id']]);

            }

            return $res;

        } else {

            return false;

        }

    }

    public function getDays($p_id)
    {

        $days = array();

        $res = $this->dbRead->select("SELECT day, time_min, time_max FROM schedule WHERE p_id = :id", array('id' => $p_id));

        foreach ($res as $val) {

            $days[$val['day']] = $val;

        }

        return $days;

    }

    public function getPromotionInfo($id)
    {

        $res = $this->dbRead->select("SELECT * FROM promotion WHERE id = :id", array('id' => $id));

        if ($res) {
            $res[0]['category'] = $this->dbRead->select("SELECT value FROM prom_cat WHERE prom_id = :id", array('id' => $id));
            $res[0]['schedule'] = $this->dbRead->select("SELECT day, time_min, time_max FROM schedule WHERE p_id = :id", array('id' => $id));
        }
        return ($res ? $res[0] : false);

    }

    public function is_galerry($img)
    {

        return $this->dbRead->select("SELECT 1 FROM gallery WHERE src = :src", array('src' => $img));

    }

    public function updatePromImg($src, $id)
    {

        $id = $this->dbRead->select('SELECT vendor_id FROM promotion WHERE id = :id', ['id' => $id]);

        $this->lastModefied($id[0]['vendor_id']);

        return $this->dbWrite->update('promotion', array('img' => $src), "id={$id}");

    }

    public function updatePromoInfo($id, $name, $value)
    {

        $ids = $this->dbRead->select('SELECT vendor_id FROM promotion WHERE id = :id', ['id' => $id]);

        $this->dbWrite->update('promotion_edit', [$name => '1'], 'prom_id=' . $id);

        $this->lastModefied($ids[0]['vendor_id']);

        return $this->dbWrite->update('promotion', array($name => trim($value)), 'id=' . $id);

    }

    public function addPromInfo($vendor, $sport, $name, $value)
    {

        $this->lastModefied($vendor);

        $this->dbWrite->insert('promotion', array('vendor_id' => $vendor, 'sport_id' => $sport, $name => $value));

        return $this->dbRead->lastInsertId();

    }

    public function getPromPrice($id)
    {

        return $this->dbRead->select("SELECT id,name, old_price, new_price, discount FROM prices WHERE promotion_id = :id", array('id' => $id));

    }

    public function addPrice($standart_price, $discount_perc, $final_price, $description_price, $id)
    {

        $res = $this->dbWrite->insert('prices', [
            'promotion_id' => $id,
            'old_price' => $standart_price,
            'new_price' => $final_price,
            'discount' => $discount_perc,
            'name' => $description_price
        ]);

        if ($res) {

            $id = $this->dbRead->lastInsertId();

            $this->dbWrite->insert('prices_edit', ['old_price' => '1', 'new_price' => '1', 'name' => '1', 'price_id' => $id]);

            $res = [
                'status' => 'success',
                'data' => [
                    'price_id' => $id,
                    'standart_price' => $standart_price,
                    'final_price' => $final_price,
                    'discount_perc' => $discount_perc,
                    'description_price' => $description_price
                ]
            ];

        }

        return $res;

    }

    public function deletePrices($id)
    {

        return $this->dbWrite->delete('prices', 'promotion_id=' . $id);

    }

    public function promAddMark($id, $name, $location)
    {

        $ids = $this->dbRead->select('SELECT vendor_id FROM promotion WHERE id = :id', ['id' => $id]);

        $this->dbWrite->update('promotion_edit', ['address' => '1'], 'prom_id=' . $id);

        $this->lastModefied($ids[0]['vendor_id']);

        if ($this->dbWrite->insert("prom_maps", array('prom_id' => $id, 'name' => $name, 'x' => $location[0], 'y' => $location[1]))) {

            return $this->dbRead->lastInsertId();

        } else {

            return false;

        }

    }

    public function getPromMarks($id)
    {

        return $this->dbRead->select("SELECT * FROM prom_maps WHERE prom_id = :id", array('id' => $id));

    }

    public function deletePromMap($id)
    {

        return $this->dbWrite->delete("prom_maps", 'id=' . $id);

    }

    public function editCat($status, $value, $id)
    {

        $ids = $this->dbRead->select('SELECT vendor_id FROM promotion WHERE id = :id', ['id' => $id]);

        $this->dbWrite->update('promotion_edit', ['category' => '1'], 'prom_id=' . $id);

        $res = false;

        switch ($status) {

            case 'add':

                $res = $this->dbWrite->insert('prom_cat', array('prom_id' => $id, 'value' => $value));

                break;

            case 'delete':

                $res = $this->dbWrite->delete('prom_cat', "prom_id ={$id} AND value='{$value}'");

                break;

        }

        $this->lastModefied($ids[0]['vendor_id']);

        return ($res ? $this->dbRead->select('SELECT value FROM prom_cat WHERE prom_id = :id', array('id' => $id)) : false);

    }

    public function editPromDay($day, $max, $min, $id)
    {

        $ids = $this->dbRead->select('SELECT vendor_id FROM promotion WHERE id = :id', ['id' => $id]);

        $this->dbWrite->update('promotion_edit', ['schedule' => '1'], 'prom_id=' . $id);

        $this->dbWrite->query("INSERT INTO schedule (`p_id`, `day`, `time_min`, `time_max`) VALUES ('{$id}', '{$day}', '{$min}', '{$max}') ON DUPLICATE KEY UPDATE `time_min` = '{$min}', `time_max` = '{$max}'");

        $this->lastModefied($ids[0]['vendor_id']);

    }

    public function editGolden($status, $id)
    {

        $this->lastModefied($id);

        return $this->dbWrite->update('section', array('is_golden' => $status), 'vendor_id=' . $id);

    }

    public function editGender($val, $id)
    {

        $ids = $this->dbRead->select('SELECT vendor_id FROM promotion WHERE id = :id', ['id' => $id]);

        $this->dbWrite->update('promotion_edit', ['gender' => '1'], 'prom_id=' . $id);

        $this->lastModefied($ids[0]['vendor_id']);

        return $this->dbWrite->update('promotion', array('gender' => $val), 'id=' . $id);

    }

    public function getAllMap($v_id, $s_id, $p_id)
    {

        $res = $this->dbRead->select(
            "SELECT
				id, 
				name 
			FROM 
				prom_maps 
			WHERE 
				prom_id != :p_id 
				AND prom_id IN 
					(SELECT 
						id
					FROM
						promotion
					WHERE 
						vendor_id = :v_id)
				AND name NOT IN 
					(SELECT 
						name 
					FROM 
						prom_maps 
					WHERE 
						prom_id = :p_id
					) 
				GROUP BY name",
            array(
                'p_id' => $p_id,
                'v_id' => $v_id
            )
        );

        return $res;

    }

    public function addPromMark($id, $map)
    {

        $mapInfo = $this->dbRead->select("SELECT x, y, name FROM prom_maps WHERE id = :id", array('id' => $map));

        $this->dbWrite->update('promotion_edit', ['address' => '1'], 'prom_id=' . $id);

        if ($mapInfo) {

            if ($this->dbWrite->insert('prom_maps', array('x' => $mapInfo[0]['x'], 'y' => $mapInfo[0]['y'], 'name' => $mapInfo[0]['name'], 'prom_id' => $id))) {

                $ids = $this->dbRead->select('SELECT vendor_id FROM promotion WHERE id = :id', ['id' => $id]);
                $this->lastModefied($ids[0]['vendor_id']);

                return array('id' => $this->dbRead->lastInsertId(), 'x' => $mapInfo[0]['x'], 'y' => $mapInfo[0]['y'], 'name' => $mapInfo[0]['name']);

            } else {

                return false;

            }

        } else {

            return false;

        }

    }

    /*
    public function getAllMaps ($v_id, $s_id) {

        $res ['sport']  = $this -> dbRead -> select ("SELECT x, y FROM prom_maps WHERE prom_id IN (SELECT id FROM promotion WHERE vendor_id = :v_id AND sport_id = :s_id )", array ('v_id' => $v_id, 's_id' => $s_id));

        $res['others'] = $this -> dbRead -> select ("SELECT x, y FROM prom_maps WHERE prom_id IN (SELECT id FROM promotion WHERE vendor_id = :v_id AND sport_id != :s_id ) AND x NOT IN (SELECT x FROM prom_maps WHERE prom_id IN (SELECT id FROM promotion WHERE vendor_id = :v_id AND sport_id = :s_id )) AND y NOT IN (SELECT y FROM prom_maps WHERE prom_id IN (SELECT id FROM promotion WHERE vendor_id = :v_id AND sport_id = :s_id ))", array ('v_id' => $v_id, 's_id' => $s_id));

        return $res;

    }
    */
    public function getAllMaps($v_id, $s_id)
    {

        $res = $this->dbRead->select(
            "SELECT
				pm.x, pm.y,
				p.name,
				p.vendor_id, 
				(SELECT src FROM prom_galery WHERE p_id = p.id LIMIT 1) as img 
			FROM 
				prom_maps as pm 
			INNER JOIN 
				promotion as p
			ON 
				(pm.prom_id = p.id)
			WHERE 
				pm.prom_id IN 
					(SELECT 
						id 
					FROM 
						promotion 
					WHERE 
						vendor_id = :v_id 
						AND sport_id = :s_id 
					)"
            , array(
                'v_id' => $v_id,
                's_id' => $s_id
            )
        );

        return $res;
    }

    public function convertTime($val)
    {

        $hours = floor($val / 60);
        $minutes = $val - ($hours * 60);

        $time = '';
        $h = $hours;
        if ($hours < 12 || $hours == 24) {

            $time = "AM";
            $h = ($hours == 0 ? 12 : $hours);
            $h = ($hours == 24 ? 12 : $hours);

        } else {

            $time = "PM";

            $h = ($hours > 12 ? $hours - 12 : $hours);

        }

        $m = ($minutes < 10 ? "0" . $minutes : $minutes);

        return $h . ":" . $m . " " . $time;

    }

    public function deletePromotion($id)
    {

        $ids = $this->dbRead->select('SELECT vendor_id FROM promotion WHERE id = :id', ['id' => $id]);

        $res = false;

        $res = $this->dbWrite->delete("promotion", "id={$id}");
        $this->dbWrite->delete("prices", "promotion_id={$id}");
        $this->dbWrite->delete("schedule", "p_id={$id}");
        $this->dbWrite->delete("prom_maps", "prom_id={$id}");
        $this->dbWrite->delete("prom_cat", "prom_id={$id}");

        $this->dbWrite->query("DELETE FROM promotion_edit WHERE prom_id NOT IN (SELECT id FROM promotion)");
        $this->dbWrite->query("DELETE FROM prices_edit WHERE price_id NOT IN (SELECT id FROM promotion)");

        if ($ids)
            $this->lastModefied($ids[0]['vendor_id']);

        return $res;

    }

    public function deleteSports($v_id, $s_id)
    {

        $this->lastModefied($v_id);

        $promotions = $this->getVendorPromotion($v_id, $s_id);

        if ($promotions) {

            foreach ($promotions as $val) {

                $this->deletePromotion($val['id']);

            }

            return true;

        }

    }

    public function deletePrice($id)
    {

        return $this->dbWrite->delete('prices', 'id=' . $id);

    }

    public function addPromGallery($name, $id)
    {

        $ids = $this->dbRead->select('SELECT vendor_id FROM promotion WHERE id = :id', ['id' => $id]);

        $this->dbWrite->update('promotion_edit', ['gallery' => '1'], 'prom_id=' . $id);

        $this->lastModefied($ids[0]['vendor_id']);

        return $this->dbWrite->insert('prom_galery', ['p_id' => $id, 'src' => $name]);

    }

    public function getPromGallery($id)
    {

        return $this->dbRead->select("SELECT src, id FROM prom_galery WHERE p_id = :id", ['id' => $id]);

    }

    public function deletePromGallery($src)
    {

        return $this->dbWrite->delete('prom_galery', "src = '{$src}'");

    }

    /*
    public function editPrice ($id, $name, $value) {

        $ids = $this -> dbRead -> select ("SELECT prom.vendor_id FROM prices as p INNER JOIN promotion as prom ON (prom.id = p.promotion_id) WHERE p.id = :id", ['id' => $id]);

        if ($name == 'discount') {

            $d = $value / 100;

            $this -> dbWrite -> query ("UPDATE prices SET new_price = old_price - (old_price * {$d}) WHERE id = {$id}");

        } else {

            $this -> dbWrite -> update ('prices_edit', [$name => '1'], 'price_id='.$id);

        }

        $this -> lastModefied ($ids[0]['vendor_id']);

        return $this -> dbWrite -> update ('prices', [$name => $value], "id={$id}");

    }
    */

    public function editPrice($id, $array)
    {

        $data = [
            'old_price' => $array['standart_price'],
            'new_price' => $array['final_price'],
            'discount' => $array['discount_perc'],
            'name' => $array['description_price'],
        ];

        $res = $this->dbWrite->update('prices', $data, "id={$id}");

        if ($res) {

            $info = $this->dbRead->select("SELECT * FROM prices WHERE id = :id", ['id' => $id]);

            $info = $info ? $info [0] : false;

            $res = [
                'status' => 'success',
                'data' => $info,
            ];

        }

        return $res;

    }

    public function createPromotions($sport_id, $id)
    {

        $default = [
            'name' => "Promotion name",
            'age_min' => 1,
            'age_max' => 99,
            'gender' => 'all',
            'valid' => 0,
            's_desc' => 'Describe your promotion.Input as much information as you can to answer any of the customer\'s questions.',
            'f_desc' => 'Describe your promotion.Input as much information as you can to answer any of the customer\'s questions.',
            'vendor_id' => $id,
            'sport_id' => $sport_id,
        ];

        $info = $this->dbRead->select("SELECT address, x, y FROM section WHERE vendor_id = :id", ['id' => $id]);

        if ($this->dbWrite->insert('promotion', $default)) {

            $prom_id = $this->dbRead->lastInsertId();

            $this->dbWrite->insert('promotion_edit', ['prom_id' => $prom_id]);

            if (!empty($info[0]['address']))
                $this->dbWrite->insert('prom_maps', ['name' => $info[0]['address'], 'x' => $info[0]['x'], 'y' => $info[0]['y'], 'prom_id' => $prom_id]);

            $res = $this->dbRead->select("SELECT * FROM promotion WHERE id = :id", ['id' => $prom_id]);

            $this->lastModefied($id);

            return $res ? $res[0] : false;

        } else {

            return false;

        }
    }

    public function editAges($name, $value, $id)
    {

        $ids = $this->dbRead->select('SELECT vendor_id FROM promotion WHERE id = :id', ['id' => $id]);

        $this->dbWrite->update('promotion_edit', [$name => '1'], 'prom_id=' . $id);

        $this->lastModefied($ids[0]['vendor_id']);

        return $this->dbWrite->update('promotion', array($name => $value), 'id=' . $id);

    }

    public function editVendorEmail($value, $id)
    {

        $this->lastModefied($id);

        return $this->dbWrite->update('vendor', ['email' => $value], 'id=' . $id);

    }

    public function lastModefied($id)
    {

        if ($this->dbRead->select("SELECT 1 FROM vendor WHERE id = :id", ['id' => $id]))
            $this->dbWrite->query('UPDATE section SET modified = NOW() WHERE vendor_id = ' . $id);

        $this->changePercent($id);

    }

    public function changeColor($id, $color)
    {

        switch ($color) {

            case 'red' :

                $this->dbWrite->update('section', ['color' => 'red'], 'vendor_id=' . $id);

                return $this->dbWrite->update('promotion', ['display' => '0'], 'vendor_id=' . $id);

                break;
            case 'yellow' :

                $this->dbWrite->update('section', ['color' => 'yellow'], 'vendor_id=' . $id);

                return $this->dbWrite->update('promotion', ['display' => '0'], 'vendor_id=' . $id);

                break;
            case 'green' :

                $res = $this->dbRead->select("SELECT id FROM promotion WHERE vendor_id = :id", ['id' => $id]);

                if ($res) {

                    foreach ($res as $item) {

                        $this->dbWrite->update('promotion', ['display' => '1'], 'id=' . $item['id']);

                    }

                }

                $this->dbWrite->update('section', ['color' => 'green'], 'vendor_id=' . $id);

                return true;

                break;

        }

    }

    public function getEditInfo($id)
    {

        $res = $this->dbRead->select("SELECT * FROM section_edit WHERE vendor_id = :id", ['id' => $id]);

        return ($res ? $res[0] : false);

    }

    public function section_edit($name, $id)
    {

        $this->dbWrite->update('section_edit', [$name => '1'], 'vendor_id=' . $id);

    }

    public function getPromEditable($id)
    {

        $res = $this->dbRead->select("SELECT * FROM promotion_edit WHERE prom_id = :id", ['id' => $id]);

        return $res ? $res['0'] : false;

    }

    public function getEditPrice($id)
    {

        $res = $this->dbRead->select("SELECT * FROM prices_edit WHERE price_id = :id", ['id' => $id]);

        return $res ? $res [0] : false;

    }

    public function changePercent($id)
    {

        $this->idObject = $id;

        $this->checkCompInfo();
        $this->checkPromotions();

        $this->dbWrite->update('section', ['percent' => $this->getPercent()], 'vendor_id=' . $this->idObject);

    }

    private function checkCompInfo()
    {

        $info = $this->dbRead->select("SELECT
											name, 
											link, 
											logo, 
											gallery,
											phone_number,
											c_email,
											about 
										FROM 
											section_edit
										WHERE 
											vendor_id = :id",
            ['id' => $this->idObject]);

        if ($info) {

            $info = $info[0];

            foreach ($info as $i => $v) {

                if ($v == 0) {

                    $error = true;

                    $this->emptyIncrement();

                }

                $this->countIncrement();

            }

            if (isset ($error))
                $this->setError('company', 'Company Information not full');

        } else {

            $this->setError('company', 'It did not work to collect information on your profile');

        }

    }

    private function checkPromotions()
    {

        $promotions = $this->dbRead->select("SELECT
													e.name,
													e.age_min,
													e.age_max,
													e.gender,
													e.f_desc,
													e.s_desc,
													e.gallery,
													e.address,
													e.category,
													e.schedule,
													sport_id,
													p.id
												FROM promotion as p
												INNER JOIN promotion_edit as e
												ON (p.id = e.prom_id)
												WHERE p.vendor_id = :id
												ORDER BY sport_id", ['id' => $this->idObject]);

        if ($promotions) {

            foreach ($promotions as $i => $p_item) {

                $prices = $this->dbRead->select("SELECT
														e.name, 
														e.new_price 
													FROM 
														prices as p
													INNER JOIN
														prices_edit as e
													ON (p.id = e.price_id)
													WHERE 
														p.promotion_id = :id",
                    ['id' => $p_item['id']]);

                if ($prices) {

                    foreach ($prices as $key => $v) {

                        foreach ($v as $i => $p) {

                            if ($p == 0) {

                                $error = true;

                                $this->emptyIncrement();

                            }

                            $this->countIncrement();

                        }

                    }


                }

                foreach ($p_item as $key => $v) {

                    if ($key != 'sport_id' && $key != 'id') {

                        if ($v == 0) {

                            $error = true;

                            $this->emptyIncrement();

                        }

                        $this->countIncrement();

                    }


                }


            }

        } else {


        }

    }

    private function emptyIncrement()
    {

        $this->fields['empty']++;

    }

    private function countIncrement()
    {

        $this->fields['count']++;

    }

    private function getPercent()
    {

        return round((($this->fields['count'] - $this->fields['empty']) / $this->fields['count']) * 100);

    }

    public function getVendorInfo($id)
    {

        $res = $this->dbRead->select("SELECT
												*, v.id as id
											FROM 
												vendor as v 
											INNER JOIN
												section as s
											ON (v.id = s.vendor_id)
											WHERE 
												v.id = :id", ['id' => $id]);

        return $res ? $res[0] : false;

    }

    public function checkEmailDublicate($email, $id)
    {

        return $this->dbRead->select("SELECT 1 FROM vendor WHERE email = :email AND id != :id", ['email' => $email, 'id' => $id]);

    }

    private function setError($key, $value)
    {

        $this->error [$key][] = $value;

    }

    public function editVendor($data, $id)
    {

        if ($data['pswd']) {

            if ($data['pswd'] == $data['re_pswd']) {

                $salt = Encryption::generateRandomKey(5);

                $data['pswd'] = md5(sha1($salt) . md5($data['pswd']));
                $data['salt'] = $salt;

            }

        }

        if ($this->dbWrite->update("vendor", $this->dbRead->getTableFields('vendor', array_merge($data, array('valid' => 1)), array('id')), 'id=' . $id)) {

            $res = $this->dbWrite->update("section", $this->dbRead->getTableFields('section', $data, ['id']), 'vendor_id=' . $id);

            return $res ? true : false;

        } else {

            return false;

        }

    }

    public function getPrice($id)
    {
        $res = $this->dbRead->select('SELECT * FROM prices WHERE id = :id', ['id' => $id]);

        return $res ? $res [0] : false;
    }

    /**
     * @param array $array
     * @return bool
     * @throws Exception
     */
    function addDoing($array)
    {
        return $this->dbWrite->insert('doing', [
            'image' => $array['image'],
            'title' => $array['title'],
            'description' => $array['description'],
            'social' => $array['social'],
        ]);
    }

    /**
     * @param int $id
     * @return bool|array
     * @throws Exception
     */
    function getDoing ($id)
    {
        $res = $this -> dbRead -> selectOne("SELECT * FROM doing WHERE id = :id", ['id' => $id]);

        if ($res) {
            $data = file_get_contents($_SERVER['DOCUMENT_ROOT']."/upload/you-doing/".$res['image']);
            $i_info = getimagesize($_SERVER['DOCUMENT_ROOT']."/upload/you-doing/".$res['image']);
            $res['base64'] = $base64 = 'data:' . $i_info['mime'] . ';base64,' . base64_encode($data);

            return $res;
        }

        return false;
    }

    /**
     * @param array $array
     * @param int $id
     * @return bool
     * @throws Exception
     */
    function editDoing ($array, $id)
    {
        $info = $this->dbRead->selectOne("SELECT image FROM doing WHERE id=:id", ['id'=>$id]);

        $res = unlink($_SERVER['DOCUMENT_ROOT']."/upload/you-doing/".$info['image']);

        return $this->dbWrite->update('doing', [
            'image' => $array['image'],
            'title' => $array['title'],
            'description' => $array['description'],
            'social' => $array['social'],
        ], "id=".$id) && $res;
    }

    /**
     * @return array|bool
     * @throws Exception
     */
    function getAllDoings ()
    {
        return $this->dbRead->select("SELECT id,title,social FROM doing");
    }

}