<?php

class Route 
{

	public $pattern;
	
	public $paramNames = array();
	
	public $paramNamesPath = array();
	
	public $params = null;
	
	public $conditions = array();


	public function __construct()
	{
		
	}
	
	public function match($url) 
	{
		
		//print str_replace(array('(', ')'), array('(?:', ')?'), (string) $this->pattern) . '<p>';
		
		$patternAsRegex = str_replace('||', ':', preg_replace_callback(
			'#:([\w]+)\+?#',
			array($this, 'matchesCallback'),
			str_replace(array('(', ')'), array('(?||', ')?'), (string) $this->pattern)
		));

		if( preg_match('#^' . $patternAsRegex . '$#', $url, $paramValues) ) {
			
			//print_r($paramValues);
			
			for($i = 1; $i <= count($paramValues)/2; $i++) {
				
				if( isset($paramValues[$i]) ) {

					$this->params[] = $paramValues[$i];

				}
				
			}
			
        } else {
		
			return false;
			
		}
		
		return true;

	}
	
	public function getParams() 
	{
	
		return $this->params;
		
	}
	
	public function matchesCallback($m) 
	{

		if( isset($this->conditions[ $this->pattern ][ $m[1] ]) ) {

			if( is_array($this->conditions[ $this->pattern ][ $m[1] ]) ) {
				
				return '(?P<' . $m[1] . '>(?:' . implode('|', $this->conditions[ $this->pattern ][ $m[1] ]) . '))';

			} else {
			
				return '(?P<' . $m[1] . '>' . $this->conditions[ $this->pattern ][ $m[1] ] . ')';

			}
        } 
	
	
        if(substr($m[0], -1) === '+') {
		
			$this->paramNamesPath[ $m[1] ] = 1;
			
            return '(?P<' . $m[1] . '>.+)';
			
        }
		
        return '(?P<' . $m[1] . '>[^/]+)';	
		
	}
	
	public function condition(array $conditions)
	{
		
		$this->conditions[ $this->pattern ] = $conditions;

		$this->replace();
		
	}
	
	public function replace()
	{
		
		foreach( $this->conditions[ $this->pattern ] as $key => $condition ) {
		
			switch($condition) {
				case 'int':
					$this->conditions[ $this->pattern ][ $key ] = '\d+';
					break;
					
				case 'text':
					$this->conditions[ $this->pattern ][ $key ] = '[\w-]+';
					break;
				
				case 'intUrl':
					$this->conditions[ $this->pattern ][ $key ] = '[0-9-]+';
					break;

			}
			
		}
		
	}
	
}