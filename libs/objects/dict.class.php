<?php

class Dict
{
	/**
	 * Dictionary class
	*/
	
	protected $alive = 86400; // day
	protected $lang_id;
	public $app;

	public function __construct($app ,$lang_id)
	{
		
		$this->lang_id = $lang_id;
		$this->app = $app;
		
		$this->dbRead = db::getInstance('read');
		
	}
	
	public function val($id, $field) {
		
		if(is_array($field)) {
			
			
			
		} else {
		
			$val = $this->app->mem->get('lang_' . $this->lang_id . '_' . $id . '_' . $field);
			
			if ($val) {
			
				return $val;
				
			} else {
			
				$res = $this->dbRead->select("SELECT `$field` As val FROM dictionary_info WHERE lang_id=:lang_id AND p_id=:p_id", array('lang_id' => $this->lang_id, 'p_id' => $id) );
				
				if($res) {
					
					$this->app->mem->set('lang_' . $this->lang_id . '_' . $id . '_' . $field, $res[0]['val'], 0, $this->alive);
					
					return $res[0]['val'];
					
				}
				
			}
		
		}
		
		return '';
		
	}
	
	public function set($id, $field, $val) {
	
		$this->app->mem->replace('lang_' . $this->lang_id . '_' . $id . '_' . $field, $val, 0, $this->alive) || $this->app->mem->set('lang_' . $this->lang_id . '_' . $id . '_' . $field, $val, 0, $this->alive); 
		
	}


}