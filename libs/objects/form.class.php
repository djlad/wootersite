<?php

class Form {

	protected $form = array();
	protected $templateDir;
	public $compiledForm = array();
	
	public function __construct($name = false, $action = '', $method = 'POST', $attributes = array())
	{
	
		$this->templateDir  = $name;
		$this->form['form'] = array("type" => 'form', "name" => $name, "method" => $method, "action" => $action, "enctype" => "multipart/form-data", "attributes" => $attributes);

	}
	
	public function add($type)
	{
	
		$args = array_slice( func_get_args(), 1 );
	
		if( $type == 'radio' || $type == 'checkbox' ) {
			
			if( func_num_args()-1 < 2 ) {
				
				throw new Exception("Need at least 2 params for " . $type);
				
			}

			$name = $args[0];
			
			
			$fieldName = $this->getFieldName($name);

			$values = $args[1];
			$defaultValues = !empty( $args[2] ) ? $args[2] : array();
			$attributes = !empty( $args[3] ) ? $args[3] : array();
			
					
			if( !empty($this->form[ $fieldName ]['label']) ) {
			
				$this->form[ $fieldName ] = array("type" => $type, "name" => $name, "value" => $values, "attributes" => $attributes, "defaultValues" => $defaultValues, "label" => $this->form[ $fieldName ]['label']);
			
			} else {
			
				$this->form[ $fieldName ] = array("type" => $type, "name" => $name, "value" => $values, "attributes" => $attributes, "defaultValues" => $defaultValues);

			}

		} elseif( $type == 'label' ) {
				
			if( func_num_args() - 1 < 2 ) {
				
				throw new Exception("Need at least 2 params for " . $type);
				
			}
				
			$for = $args[0];
			$caption = $args[1];
			$attributes = !empty( $args[2] ) ? $args[2] : array();
			
			$this->form[ $for ]['label'] = array("type" => $type, "for" => $for, "caption" => $caption, "attributes" => $attributes);
		
		} elseif( $type == 'select' ) {
		
			if( func_num_args()-1 < 2 ) {
				
				throw new Exception("Need at least 2 params for " . $type);
				
			}

			$name = $args[0];
			
			
			$values = $args[1];
			
			$defaultSelected = !empty($args[2]) ? $args[2] : '';
			
			$attributes = !empty( $args[3] ) ? $args[3] : array();
			
		
			
			if( !empty($this->form[ $name ]['label']) ) {
			
				$this->form[ $name ] = array("type" => $type, "name" => $name, "value" => $values, "attributes" => $attributes, "label" => $this->form[ $name ]['label'], "defaultSelected" => $defaultSelected);
			
			} else {
			
				$this->form[ $name ] = array("type" => $type, "name" => $name, "value" => $values, "attributes" => $attributes, "defaultSelected" => $defaultSelected);

			}
		
		
		} else {
						
			$name 		= trim( $args[0] );
			$value 		= !empty( $args[1]) ? $args[1] : '';
			
			if( isset($_POST[ $name ]) ) {
			
				$value = ( $_POST[ $name ] );
							
			}
			
			$attributes = !empty( $args[2] ) ? $args[2] : array();
			
			if( empty($name) ) {
				
				throw new Exception("Name can not be empty");
			
			}		
			
			if( !empty($this->form[ $name ]['label']) ) {
			
				$this->form[ $name ] = array("type" => $type, "name" => $name, "id" => $name, "value" => $value, "attributes" => $attributes, "label" => $this->form[ $name ]['label']);
			
			} else {
			
				$this->form[ $name ] = array("type" => $type, "name" => $name, "id" => $name, "value" => $value, "attributes" => $attributes);

			}
			
		}
		
	
	}
	
	public function render($formDir)
	{
		$tpl = new Template();
		$fields = array();
		
		foreach( $this->form as $key => $value ) {
			
			if( empty($value['type']) ) {
			
				throw new Exception("Need add field to label");
			
			}
			
			if( $value['type'] == 'form' ) {
				
				$name = $value['name'];
				$method = $value['method'];
				$enctype = $value['enctype'];
				$action = $value['action'];
				$attributes_array = $value['attributes'];
				$attributes = '';
				
				if( !empty($attributes_array) ) {
				
					foreach( $attributes_array as $attr => $attrv ) {
					
						$attributes .= $attr . '="' . $attrv . '" ';
					
					}
					
					$attributes = ' ' . rtrim($attributes, ' ');
					
				}
				
				$tpl->addVar('name', $name);
				$tpl->addVar('method', $method);
				$tpl->addVar('enctype', $enctype);
				$tpl->addVar('action', $action);
				$tpl->addVar('attributes', $attributes);

				$fields['open_form'] = $tpl->display('open_form', 'forms', $formDir, true);
			
			} elseif( $value['type'] == 'checkbox' || $value['type'] == 'radio' || $value['type'] == 'select' ) {

				if( !empty($value['label']) ) {
					
					$for = $value['label']['for'];
					$caption = $value['label']['caption'];
					$attributes_array = $value['label']['attributes'];

					if( !empty($attributes_array) ) {
					
						foreach( $attributes_array as $attr => $attrv ) {
						
							$attributes .= $attr . '="' . $attrv . '"';
						
						}
						
						$attributes = ' ' . $attributes;
						
					}
					
					$tpl->addVar('for', $for);
					$tpl->addVar('caption', $caption);
					$tpl->addVar('attributes', $attributes);
					$label = $tpl->display('label', 'forms', $formDir, true);	
				
				}
			
				$name = $value['name'];
				$type = $value['type'];
				$values = $value['value'];
		
				$attributes_array = $value['attributes'];
				
				$attributes = '';

				if( !empty($attributes_array) ) {
				
					foreach( $attributes_array as $attr => $attrv ) {
					
						$attributes .= ' ' . $attr . '="' . $attrv . '" ';
					
					}
					
					$attributes = ' ' . rtrim($attributes, ' ');
					
				}
				
			
				
				switch($type) {
					
					case 'radio':
					case 'checkbox':
							
						$defaultValues = $value['defaultValues'];
						
						$html = '';
					
						foreach($values as $k => $v) {
						
							if( $type == 'radio' ) {
							
								$selected = isset($_POST[ $name ]) && $_POST[ $name ] == $k ? 'checked="checked"' : '';
								
								if( isset($_POST[ $name ]) && $_POST[ $name ] == $k ) {
								
									$selected = 'checked="checked"';
								
								} else {
								
									if( in_array($k, $defaultValues) ) {
									
										$selected = 'checked="checked"';
									
									} else {
									
										$selected = '';
									
									}
								
								}
							
							} elseif ( $type == 'checkbox' ) {
								
								$fieldName = $this->getFieldName($name);
							
								if( isset($_POST[ $fieldName ]) ) {
									
									if( is_array($_POST[ $fieldName ]) ) {
										
										$selected = in_array($k, $_POST[ $fieldName ]) ? 'checked="checked"' : '';
										
									} else {
									
										$selected = $_POST[ $fieldName ] == $k ? 'checked="checked"' : '';
									
									}
									
								} else {
								
									if( in_array($k, $defaultValues) ) {
									
										$selected = 'checked="checked"';
									
									} else {
									
										$selected = '';
									
									}
								
								}
							}
							
							$tpl->addVar('selected', $selected);
							$tpl->addVar('type', $type);
							$tpl->addVar('name', $name);
							$tpl->addVar('value', $k);
							$tpl->addVar('caption', $v);
							
							$html .= $tpl->display($type, 'forms', $formDir, true);			
						}
						
						break;

					case 'select':
										
						$selected = '';
						
						if( $value['defaultSelected'] && !isset($_POST[ $name ] ) ) {
						
							$selected = $value['defaultSelected'];
						
						} else if( isset($_POST[ $name ] ) ) {
						
							$selected = app::sanitize($_POST[ $name ]);
						
						}

						$tpl->addVar('name', $name);
						$tpl->addVar('values', $values);
						$tpl->addVar('selected', $selected);
						$tpl->addVar('id', $name);
						$tpl->addVar('attributes', $attributes);
						$html = $tpl->display('select', 'forms', $formDir, true);
						
						break;					
				
				}
				
				$fields[ $key ]['field'] = $html;

				if( !empty($label) ) {
				
					$fields[ $key ]['label'] = $label;
				}				
			
			} else {
				
				if( !empty($value['label']) ) {
				
				
					$for = $value['label']['for'];
					$caption = $value['label']['caption'];
					$attributes_array = $value['label']['attributes'];

					if( !empty($attributes_array) ) {
					
						foreach( $attributes_array as $attr => $attrv ) {
						
							$attributes .= $attr . '="' . $attrv . '"';
						
						}
						
						$attributes = ' ' . $attributes;
						
					}
					
					$tpl->addVar('for', $for);
					$tpl->addVar('caption', $caption);
					$tpl->addVar('attributes', $attributes);
					$label = $tpl->display('label', 'forms', $formDir, true);					
				
				}
				
				
				
				$name = $value['name'];
				$val = $value['value'];
				$type = $value['type'];
				$inputType = $type;
				$id = $value['name'];
				$attributes_array = $value['attributes'];
			
				$attributes = '';
				
				if( !empty($attributes_array) ) {
				
					foreach( $attributes_array as $attr => $attrv ) {
					
						$attributes .= $attr . '="' . $attrv . '"';
					
					}
					
					$attributes = ' ' . $attributes;
					
				}
						
				if( $value['type'] == 'text' || $value['type'] == 'password' || $value['type'] == 'file' || $value['type'] == 'submit' || $value['type'] == 'hidden' ) {
				
					$type = 'input';
				
				}
				
				$tpl->addVar('type', $inputType);
				$tpl->addVar('id', $id);
				$tpl->addVar('name', $name);
				$tpl->addVar('value', $val);
				$tpl->addVar('attributes', $attributes);
				
				$html = $tpl->display($type, 'forms', $formDir, true);

				$fields[ $name ]['field'] = $html;
				
					
				if( !empty($label) ) {
				
					$fields[ $name ]['label'] = $label;
				}
				
			}
	
		}

		
		$fields['close_form'] = '</form>';
		

		return $fields;
		
	}

	protected function getFieldName($name) {

		return $fieldName = preg_match("/[\w+]\[\]/", $name) ? substr($name, 0, -2) : $name;
			
	}
}