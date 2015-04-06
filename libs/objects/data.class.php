<?php


class Data {
	
	public static function setCookie($name, $value, $expire_time = 0, $url = '/')
	{

		return setcookie($name, $value, time() + 60 * 60 * $expire_time, $url);
		
	}
	
	public static function getCookie($name)
	{
			
		return isset($_COOKIE[ $name ]) ? $_COOKIE[ $name ] : false;
	
	}
	
	public static function deleteCookie($name)
	{
	
		setcookie($name, '', time(), '/');
	
	}	
	
	public static function startSession()
	{
		
		session_start();
	
	}
	
	public static function setSession($name, $value)
	{
	
		$_SESSION[ $name ] = $value;
	
	}
	
	public static function deleteSession($name)
	{
	
		unset($_SESSION[ $name ]);
		
	}
}

