<?php

class App 
{
	/**
	 * Template directory
	 *
	 * @var string
	*/
	
	protected $apps = array();
	public $mem;
	public $router;
	public $route;
	public $error;
	public $path;
	public $conditionsToAdd = array();

	public function __construct()
	{
		
		/*$this->mem = new Memcache();
		$this->mem->addServer('localhost');*/

		$this->router = new Router($this);
		$this->route = new Route();
		$this->error = new Error();
		
		$this->path = $this->router->includeFile();
		
		if( !$this->path ) {
		
			$this->setError(404);
		
		}
		
	}

    /**
     * @return bool|string
     */
	public function getPath() {
	
		return $this->path;
		
	}

    /**
     * @param $pattern
     * @param null $callback
     * @return Route
     */
	public function get($pattern, $callback = null) 
	{
		
		$this->apps[] = array("pattern" => $pattern, "callback" => $callback, "method" => "get/post");
		
		$this->route->pattern = $pattern;
		
		return $this->route;
		
	}

    /**
     * @param $pattern
     * @param null $callback
     * @return Route
     */
	public function post($pattern, $callback = null) 
	{
	
		$this->apps[] = array("pattern" => $pattern, "callback" => $callback, "method" => "post");
		
		$this->route->pattern = $pattern;
		
		return $this->route;
		
	}

    /**
     * @param $pattern
     * @param null $callback
     * @return Route
     */
	public function ajax($pattern, $callback = null) 
	{
	
		$this->apps[] = array("pattern" => $pattern, "callback" => $callback, "method" => "ajax");
		
		#echo $pattern;
		
		$this->route->pattern = $pattern;
		
		return $this->route;
		
	}

    /**
     * @param $callback
     * @param null $params
     */
	protected function call($callback, $params = null) {
	
		if( is_callable($callback) ) {
		
			if( !empty($params) ) {
			
				call_user_func_array($callback, $params);
				
			} else {
			
				call_user_func($callback);
				
			}
			
		} else {
		
			$this->setError(404);
			
		}
		
	}

    /**
     *  run app
     */
	public function run()
	{
	
		set_error_handler(array($this->error, 'errorHandler'));
		
		try {
		
			$match = false;
			
			foreach($this->apps as $app) {
			
				$this->route->pattern = $app['pattern'];
				
				$match = $this->route->match($this->router->getUrl());
				
				if( $match ) {
				
					$request_method = $app['method'];
						
					if( $this->isValidMethod($request_method) ) {
					
						$params = $this->route->getParams();
						
						$this->call($app['callback'], $params);
						break;
					
					} else {
					
						$match = false;
						break;
					
					}
					
				}
			}
			
			if( !$match ) {
			
				$this->setError(404);
				
			}
			
		} catch(Exception $error) {
		
			if( ENVIRONMENT == 'dev' ) {

				echo $this->error->renderBody($error);
				
			} else {
				
				$this->error->writeLog($error);
				
				$this->setError(503);
			}
			
		}
		
	}
	
	public function setError($code) {
	
		$this->error->setError($code);
		
	}
	
	public function redirect($location)
	{
	
		$this->error->redirect($location);
		
	}

    /**
     * @param $request_method
     * @return bool
     */
	protected function isValidMethod($request_method)
	{
		
		if( $request_method == 'get/post' && !isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
			
			return strtolower($_SERVER['REQUEST_METHOD']) == 'get' || strtolower($_SERVER['REQUEST_METHOD']) == 'post' ? true : false;
		
		} elseif( $request_method == 'post' ) {
		
			return strtolower($_SERVER['REQUEST_METHOD']) == 'post' ? true : false;
		
		} elseif( $request_method == 'ajax' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
		
			return strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ? true : false;
		
		} else {
				
			return false;
		
		}
		
	}

    /**
     * @param $string
     * @param string $lavel
     * @return array|mixed|string
     */
	public static function sanitize($string, $lavel = 'tag')
	{
		if(is_array($string)) {
			
			$res = array();
			
			foreach ($string As $k => $v) {
			
				$res[$k] = self::sanitize($v);
			
			}
			
			return $res;
		
		} else{
			
			switch($lavel) {
				
				case 'script':
				
					return  str_ireplace( array('<script', '</script', '<iframe', '</iframe', '<frame', '</frame'), 
										  array('<&#115;cript', '<&#47;&#115;cript', '<&#105;frame', '<&#47;&#105;frame', '<&#102;rame', '<&#47;&#102;rame'), 
										  $string );
					
					break;
			
				case 'tag':
					
					return $string;
					
					break;
				
				default:
				
					return  htmlspecialchars( $string, ENT_NOQUOTES );
					
					break;
			
			}
		
		}
	}


    /**
     * @param string $className
     * @param bool $module
     * @param bool $subModule
     * @param array $params
     * @throws Exception
     * @return object
     */
	public static function getModule($className, $module = false, $subModule = false, $params = array())
	{

		$path =  './vendor/';
			
		if( $className && !$module && !$subModule ) {
		
			$path .= $className . '.class.php';
		
		} elseif( $className && $module && !$subModule ) {
		
			$path .= $module . DS . $className . '.class.php';
		
		} elseif ( $className && $module && $subModule ) {
		
			$path .= $module . DS . $subModule . DS . $className . '.class.php';
		
		} else {
		
			throw new Exception("Module can not be empty");
		
		}

		if(file_exists($path)) {
		
			include_once $path;

			return call_user_func_array( array( new ReflectionClass($className), 'newInstance' ), $params );
			
		} else {

			throw new Exception("Class " . $className . " not founded");
			
		}

		
	}
	
}