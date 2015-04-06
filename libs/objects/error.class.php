<?php

class Error extends Exception {

	public $_errorVars = array();
	
	public $_error = array( "403" => array("title" => "Forbidden", 		  				 "message" =>  "Forbidden"),
							"404" => array("title" => "Page not found", 				 "message" =>  "Page not found"),
						    "502" => array("title" => "Bad gateway",  	  				 "message" =>  "Bad gateway"),
							"503" => array("title" => "Temporarily unavailable", 		 "message" =>  "Service temporarily unavailable. Try again later")							
						   );
	
	public function __construct()
	{}
	
	public function errorHandler($errno, $errstr, $errfile, $errline) 
	{
	
		throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
		
	}
	
	public function setError($code) {
	
		if( !empty($this->_error[$code]) ) {
			
			$template = new Template();
			$template->addVar('code', $code);
			$template->addVar('title', $this->_error[$code]['title']);
			$template->addVar('message', $this->_error[$code]['message']);
			$template->display('error');
			
			exit();

		}
	}
	
	public function redirect($location, $code = false) {
		if($isCode)
			header("HTTP/1.1 301 Moved Permanently");
			
		header('location: '.$location.'');
				
		exit();
	}
	
	public function getErrorVars($exception)
	{		
	
		$this->_errorVars = array(	"code" => $exception->getCode(), 
									"message" => $exception->getMessage(), 
									"file" => $exception->getFile(), 
									"line" => $exception->getLine(),
									"trace" => $exception->getTraceAsString(), 
									"type" => get_class($exception)
									);
									
	}
	
	public function renderBody($exception)
	{
	
		$title = 'Error';
		
		$this->getErrorVars($exception);
		
		extract($this->_errorVars);
		
		$template = new Template();
		
		$template->addVar('title', $title);
		$template->addVar('file', $file);
		$template->addVar('line', $line);
		$template->addVar('type', $type);
		$template->addVar('message', $message);
		$template->addVar('trace', $trace);
		
		$template->display('errorHandler');	
		
	}
	
	public function writeLog($exception)
	{
	
		$this->getErrorVars($exception);
		extract($this->_errorVars);
		$error = $message.' '.$file.':'.$line;
		
		if( !is_dir (ERROR_DIR) ) {
		
			mkdir( ERROR_DIR, 0777);
			
		}
		
		$handle = fopen(ERROR_DIR . DS . 'error.logs', "a");
		fwrite($handle, $error." ".date("d.m.Y H:i:s")."\r\n");
		fclose($handle);
		
	}
}