<?php

class Router
{

	public $url;
	public $dbRead;
	public $app;
	
	public function __construct($app)
	{
		$this->app = $app;
	
		$url = isset($_SERVER['REQUEST_URI']) ? trim($_SERVER['REQUEST_URI']) : null;
		$url = rtrim($url, '/');
		$url = filter_var($url, FILTER_SANITIZE_URL);

		$this->url = $url == '' ? '/' : $url;
		
		$this->dbRead = db::getInstance('read');
		
	}
	
	public function getUrl() {
	
		return $this->url;
		
	}
	
	public function includeFile() {
		
		$lang = "";
		
		$url = ltrim( $this->url, '/');
		if($url == '') {
		
			$url = array();
			
		} else {
		
			$url = explode("/", $url);
		
		}
		
		if( count($url) >= 1 && !file_exists('./modules/' . $url[0]) ) {
			/*
			$langs = $this->app->mem->get('_LANGS');
			
			if(!$langs) {
			
				$res = $this->dbRead->select("SELECT code FROM languages WHERE isDefault='0'");
				
				foreach($res As $val) {
				
					$langs[] = $val['code'];
					
				}
					
				$this->app->mem->set('_LANGS', $langs, 0, 3600);
				
			}

			if ($langs){
			
				if(in_array($url[0], $langs)) {

					$lang = array_shift($url);
					$this->url = '/' . implode('/', $url);

				}
			
			}
			*/
		}
		
		define("_LANG", $lang);
		
		if ( count($url) >= 1 ) {
				
			if( count($url) > 1 && file_exists('./modules/' . $url[0] . '/' . $url[1]) ) {
			
				return './modules/' . $url[0] . '/' . $url[1] . '/index.php';
				
			} elseif( count($url) >= 1 && file_exists('./modules/' . $url[0]) ) {
				
				return './modules/' . $url[0] . '/index.php';
				
			} elseif( !file_exists('./modules/' . $url[0]) ) {
			
				return './modules/default/index.php';
				
			}
			
			return false;
			
		}
		
		return './modules/default/index.php';
		
	}
}