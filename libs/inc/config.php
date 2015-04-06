<?php
if(!defined("LOCK")) die();

mb_internal_encoding("UTF-8");

define('ERROR_DIR', './logs');
define('DS', DIRECTORY_SEPARATOR);

define('DEFAULT_MAIL', 'ddis92@gmail.com');
define('DEFAULT_MAIL_FROM', 'Wooter');
define('DB_CHARSET', 'utf-8');

$CONFIG['DB']['MASTER']['DRIVER'] = "mysql";
$CONFIG['DB']['MASTER']['HOST'] = "myspeedt.mysql.ukraine.com.ua";
$CONFIG['DB']['MASTER']['DATABASE'] = "myspeedt_wooter";
$CONFIG['DB']['MASTER']['USER'] = "myspeedt_wooter";
$CONFIG['DB']['MASTER']['PASS'] = "hxj9gam2";

$CONFIG['DB']['SLAVE']['DRIVER'] = "mysql";
$CONFIG['DB']['SLAVE']['HOST'] = "myspeedt.mysql.ukraine.com.ua";
$CONFIG['DB']['SLAVE']['DATABASE'] = "myspeedt_wooter";
$CONFIG['DB']['SLAVE']['USER'] = "myspeedt_wooter";
$CONFIG['DB']['SLAVE']['PASS'] = "hxj9gam2";

$active_template = 'wooter';
define('ACTIVE_TEMPLATE', $active_template);

define('SECRET_KEY', '99hGr');// should be changed
define('USER_SESSION_TIME', 30); // user session time


# ADMIN CONFIG

define('ADMIN_PATH', '/admin');