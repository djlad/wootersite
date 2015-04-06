<?php

class File {
	public $_files = array();
	public $path = './uploads';
	public $maxSize = '10';
	public $allowedExtensions = array();
	public $rename = true;
	
	public function __construct() {
	}
	
	public function setFile($fileName, $path = false, $allowedExtensions = false, $maxSize = false, $rename = false)
	{
	
		$path = $path == '' ? $this->path : $path;
		$allowedExtensions = $allowedExtension == '' ? $this->allowedExtension : $allowedExtension;
		$maxSize = $maxSize == '' ? $this->maxSize : $maxSize;
		$rename = $rename == '' ? $this->rename : $rename;		
		
		$file = $_FILES[ $fileName ];
		
		$newName = $rename == true ? $this->generateName() : $this->getName($file['name']);
		
		
		
		$this->_files[ $fileName ] = array(
										"name" => $file['name'],
										"newName" => $newName,
										"path" => $path,
										"tmp_name" => $file['tmp_name'], 
										"extension" => $this->getExtension($file['name']),
										"size" => $file['size'],
										"maxSize" => $this->convertSize($maxSize),
										"allowedExtensions" => $allowedExtensions,
										"mimeType" => $file['test']
										);
	
	}
	
	public function generateName()
	{
	
		return uniqid();
		
	}
	
	public function rename()
	{
		
		$this->rename = false;
		
	}
	
	public function getName($file) {
	
		$fileName = explode(".", $file);
		$length = strlen(end($fileName))+1;
		
		$fileName = mb_substr($file, 0, -$length);
		
		
		return $fileName;		
	
	}
	
	public function setPath($path)
	{
		
		$this->path = $path;
		
	}
	
	public function getPath() 
	{
	
		return $this->path;
		
	}
	
	public function setMaxSize($maxSize)
	{
		
		$this->maxSize = $maxSize;
		
	}
	
	public function getMaxSize()
	{
	
		return $this->maxSize;
	
	}
	
	public function setAllowedExtensions($types = array())
	{
	
		$this->allowedExtensions = $types;
	
	}
	
	public function getAllowedExtensions()
	{
	
		return $this->allowedExtensions;	
	
	}	
	
	public function getMimeType($file) {
	
		return $this->_files[ $file ]['mimeType'];
	
	}

	public function getExtension($file)
	{

		$fileName = explode(".", $file);
		$extension = end($fileName);
		
		return $extension;
	
	}
	
	public function convertSize($size)
	{
		
		return $size * 1024 * 1024;
	
	}
	
	public function isValidFormat($file)
	{
		
		$extension = $this->_files[ $file ]['extension'];
		
		$allowedExtensions = $this->_files[ $file ]['allowedExtensions'];
		
		if( !empty($allowedExtension) ) {
		
			return in_array($format, $allowedExtensions) ? true : false;
			
		} else {
		
			return true;
		
		}
		
	}
	
	public function isUploaded($file) {
	
		return is_uploaded_file($_FILES[ $file ]['tmp_name']) ? true : false;
	
	}	
	
	public function upload($file) {
		
		return move_uploaded_file($this->_files[ $file ]['tmp_name'], $this->_files[ $file ]['path'] . '/' . $this->_files[ $file ]['newName'] . '.' . $this->_files[ $file ]['extension']) ? true : false;
	
	}
}