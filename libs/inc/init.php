<?php
if(!defined("LOCK")) die();

include_once $_SERVER['DOCUMENT_ROOT'].'/libs/inc/config.php';

$app = new App();

/**
 * Checking ENVIRONMENT
 */
switch(ENVIRONMENT) {
	case 'dev':
		ini_set('display_errors', 1);
		error_reporting(E_ALL);
		break;
		
	case 'production':
		ini_set('display_errors', 0);
		error_reporting(0);
		break;

	default:
		$app->setError('503');
		break;
}

/**
 * Loading app path by URL
 * ie: if URL: /news/full.html
 * app will load ./modules/news/index.php file
 */


if($app->path) {

	include_once $app->path;
	
}

/**
* Autoload function
* 
* Function for loading classes
* 
* @throws Exception    If file not exists
*/

function __autoload($className) {

	global $CONFIG;
	
	$dir = './libs/objects/' . strtolower($className) . '.class.php';
	
	if(file_exists($dir)) {
	
		include_once $dir;
		
	} else {
	
		throw new Exception("Class ".$className." not founded");
		
	}
	
}