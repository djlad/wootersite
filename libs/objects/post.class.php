<?php

class Post {

	public $_errors = false; // has errors
	
	public $_data = array();	
	public $_files = array();	
	
	public function __construct($ex = array()) {
	
		foreach($_POST as $key=>$value) {
		
			if(in_array($key, $ex)) {
				
				$this->_data[ $key ] = app::sanitize( $value, 'script' );
			
			} else {
			
				$this->_data[ $key ] = app::sanitize( $value );
			
			}
		}

	}
	
	public function addRule($name, $rules = array()) {
		
		foreach( $rules as $key => $rule ) {
			
			switch( $key ) {
				
				case 'required':
					
					if( !$this->isRequired( $this->_data[ $name ] ) ) {
						
						$this->_errors = true;
						
						break 2;
					
					}
				
					break;
				
				case 'values':
					
					if ( !isset($this->_data[ $name ]) ) {
						
						break; // if expression not required
						
					}
				
					if( !$this->checkValues($this->_data[ $name ], $rule[0]) ) {

						$this->_errors = true;
					
						break 2;
					
					}
				
					break;
				
			
				case 'length':
					
					if ( !isset($this->_data[ $name ]) ) {
						
						break; // if expression not required
						
					}
					
					$minLength = $rule[0];
					$maxLength = $rule[1];
		
					if( !$this->checkLength($this->_data[ $name ], $minLength, $maxLength) ) {
					
						$this->_errors = true;
						
						break 2;
					}
					
					break;
				
				case 'regexp':
					
					if ( !isset($this->_data[ $name ]) ) {
						
						break; // if expression not required
						
					}
					
					$regexp = $rule[0];
					
					if( !$this->checkRegexp($this->_data[ $name ], $regexp) ) {
						
						$this->_errors = true;
						
						break 2;
					
					}
						
					break;
					
				case 'noregexp':
					
					if ( !isset($this->_data[ $name ]) ) {
						
						break; // if expression not required
						
					}
					
					$regexp = $rule[0];
					
					if( !$this->checkNoRegexp($this->_data[ $name ], $regexp) ) {
					
						$this->_errors = true;
						
						break 2;
					
					}
						
					break;
				
				case 'callback':
					
					if ( !isset($this->_data[ $name ]) ) {
						
						break; // if expression not required
						
					}
					
					$className = $rule[0];
					$classModule = $rule[1];
					$classSubModule = $rule[2];
					$method = $rule[3];
					
					$class = app::getModule( $className, $classModule, $classSubModule);
					
					if( !call_user_func_array( array( $class, $method ), array($this->_data[ $name ]) ) ) {
						
						$this->_errors = true;
						
						break 2;
					
					}
				
					break;

				case 'compare':
					
					if ( !isset($this->_data[ $name ]) ) {
						
						break; // if expression not required
						
					}
				
					$compareName = $rule[0];
					
					if( !isset($_POST[ $compareName] ) || ($_POST[ $compareName ] != $_POST[ $name ] )) {
						
						$this->_errors = true;
						
						break 2;
						
					}
					
					break;
					
				case 'validValue':
					
					if ( !isset($this->_data[ $name ]) ) {
						
						break; // if expression not required
						
					}
					
					if( !in_array( $this->_data[ $name ], $rule[0]) ) {
						
						$this->_errors = true;
						
						break 2;
					
					}
					
					break;
					
			}
		}
	}
	
	public function generateNewName($extension)
	{
		
		return uniqid() . '.' . $extension;
	
	}
	
	public function addFile($name, $uploadDir, $rules, $isRename = true, $isMultiply = false)
	{

	
		if( is_uploaded_file($_FILES[ $name ]['tmp_name'][0]) ) {
		
			$extension = $this->getFileExtension($_FILES[ $name ]['name'][0]);
			
			
			if( !is_dir($uploadDir) ) {
			
				mkdir($uploadDir, 0775, true);
			
			}
			
			$fileName = $isRename ? $this->generateNewName($extension) : $_FILES[ $name ]['name'];
			
			$this->_files[ $name ]['uploadPath'] = $uploadDir . DS . $fileName;		
			$this->_files[ $name ]['name'] = $fileName;		
		
			$uploaded = true;
			
		} else {
		
			$uploaded = false;
		
		}
		
		foreach( $rules as $key => $rule ) {

			switch( $key ) {
			
				case 'required':

					if( !$uploaded ) {
						
						$_errors = true;
						
						break 2;
						
					}
					
					break;
					
				case 'maxSize':
				
					$size = $_FILES[ $name ]['size'][0];
					$maxSize = $rule[0];
					
					if( !$this->checkMaxSize($size, $maxSize) ) {
					
						$_errors = true;
						
						break 2;
						
					}
				
					break;
					
				case 'validExtensions':
				
					
					$allowedExtensions = $rule[0];

					if( !$this->checkValidExtension($extension, $allowedExtensions) ) {
					
						$this->_errors = true;
						
						break 2;
					
					}
					
				
					break;
					
				case 'type':
						
					$type = $rule[0];
					$error = $rule[1];
					
					if( !$this->checkFileType($_FILES[ $name ]['name'], $type) ) {
					
						$_errors = true;
						
						break 2;
					
					}
				
					break;
						
			}
				
		}
	
	}
	
	protected function checkLength($value, $minLength, $maxLength)
	{
			
		return mb_strlen($value) >= $minLength && mb_strlen($value) <= $maxLength ? true : false;
	
	}
	
	protected function isRequired($string)
	{
	
		return $string != '' ? true : false;
	
	}
	
	protected function checkNoRegexp($value, $regexp) {
		
		if( $value != '' ) {
		
			return !preg_match($regexp, $value);
			
		} else {
		
			return true;
		
		}
	
	}
	
	protected function checkValues($value, $values) {
		
		return in_array($value, $values);
	
	}
	
	protected function checkRegexp($value, $regexp)
	{
		
		if( $value != '' ) {
	
			switch($regexp) {
			
				case 'email':

					return filter_var($value, FILTER_VALIDATE_EMAIL) ? true : false;
					
					break;
					
				case 'int':

					return is_numeric($value) ? true : false;

					break;
				
				case 'float':
				
					return preg_match('/^\d+(?:\.\d+)?$/i', $value) ? true : false;
				
					break;
					
				case 'tel':
				
					return preg_match('/^(\+?\d+)?\s*(\(\d+\))?[\s-]*([\d-]*)$/', $value) ? true : false;
				
					break;
					
				case 'login':

					return preg_match('/^[a-z]+[\w-]*[a-z0-9]$/i', $value) ? true : false;
				
					break;
					
				case 'pass':

					return preg_match('/^[a-z0-9_!@#$%^&*()+=-]{8,}$/i', $value) ? true : false;
				
					break;
					
				case 'name':
				
					return preg_match('/^[\p{L}\p{M}\p{Pc}]+[`"\' -]?[\p{L}\p{M}\p{Pc}]+$/iu', $value) ? true : false;
					
					break;
					
				case 'latin':

					return preg_match('/^[a-z]+$/i', $value) ? true : false;
				
					break;
					
				case 'skype':

					return preg_match('/^[a-zA-Z0-9,\._-]{6,32}$/i', $value) ? true : false;
				
					break;
					
				case 'url':

					return preg_match('/^[a-z0-9.-]+$/i', $value) ? true : false;
				
					break;
					
				case 'lang':

					return preg_match('/^[^0-9]+$/i', $value) ? true : false;
				
					break;	
					
				case 'words':

					return preg_match('/^[\d\p{L}\p{M}\p{Pc} .,-]+$/iu', $value) ? true : false;
				
					break;
				
				default:
					
					$all =  preg_match($regexp, $value) ? true : false;// переписать на учет модификатора
					echo $all;
					break;
				
			}
		
		} else {
		
			return true;
		
		}
		
	}
	
	public function checkMaxSize($size, $maxSize)
	{
	
		$maxSize = $maxSize * 1024 * 1024;
				
		return $maxSize > $size ? true : false;
	
	}
	
	public function checkFileType($image, $type)
	{
	
		if( $type == 'image' ) {
				
			list($width, $height, $extNum) = @getimagesize($image);
			
			if( $extNum > 3 ) return false;
	
		}
		
		return true;
	
	}
	
	public function getFileExtension($file)
	{

		$fileName = explode(".", $file);
		$extension = strtolower(end($fileName));

		return $extension;
	
	}
	
	public function checkValidExtension($extension, $allowedExtensions)
	{
		
		return in_array($extension, $allowedExtensions) ? true : false;
	
	}
	
	public function validate()
	{
		
		if( !$this->_errors ) {
	
			if( !empty($this->_files) ) {
			
				foreach($this->_files as $key => $value) {
					
					move_uploaded_file($_FILES[ $key ]['tmp_name'][0], $value['uploadPath']);
					
				}
			
			}		
	
			return true;
		
		} else {
		
			return false;
		
		}
	
	}
	
	public function getValues() {
	
		return $this->_data;

	}
	
}