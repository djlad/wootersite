<?php

class Template {
	/**
	 * Template directory
	 *
	 * @var string
	*/
	public $tplDir;

	/**
	 * Cache directory. Is the directory where class will compile the template and save the cache
	 *
	 * @var string
	*/
	public $cacheDir;

	/**
	 * Is the array where class keep the variables assigned
	 *
	 * @var array
	 */
	public $var = array();
	
	/**
	 * Template extension
	 *
	 * @var string
	 */	
	public $defaultExtension;

	/**
	 * Cache name suffix
	 *
	 * @var string
	 */	
	public $cacheSuffix;

	/**
	 * Regexps for compiling template
	 *
	 * @var string
	 */	
	public $tagRegexp = array(	'for'			=> '(\{for="[^"]*"\})',
								'for_close'   	=> '(\{\/for\})',
								'while'			=> '(\{while="[^"]*"\})',
								'while_close' 	=> '(\{\/while\})',
								'foreach'		=> '(\{foreach="[^"]*"\})',
								'foreach_close' => '(\{\/foreach\})',
								'if'          	=> '(\{if="[^"]*"\})',
								'elseif'     	=> '(\{elseif="[^"]*"\})',
								'else'       	=> '(\{else\})',
								'if_close' 	    => '(\{\/if\})',
								'else_close'    => '(\{\/else\})',
								'elseif_close' 	=> '(\{\/elseif\})',
								'include'    	=> '(\{include=[\w,\/*]+})',
							);		
	
	/**
	 * PHP tags <? ?> 
	 * True: php tags are enabled into the template
	 * False: php tags are disabled into the template and rendered as html
	 *
	 * @var bool
	 */	
	static $phpEnabled = true;

	/**
	 * Cache expire time in seconds
	 *
	 * @var string
	 */	
	static $cacheExpireTime = 0;
	
	public function __construct($tplDir = '/templates/', $cacheDir = '/cache', $defaultExtension = 'tpl', $cacheSuffix = 'infogid') {
	
		if( ENVIRONMENT == 'dev' ) {
			
			self::$cacheExpireTime = 0;
			
		} else {
		
			self::$cacheExpireTime = 31555926; //year 
		
		}

		$this->tplDir 			= $_SERVER["DOCUMENT_ROOT"] . $tplDir . ACTIVE_TEMPLATE;
		$this->cacheDir 		= $_SERVER["DOCUMENT_ROOT"] . $cacheDir;
		$this->defaultExtension = $defaultExtension;
		$this->cacheSuffix 		= $cacheSuffix;
		
	}

	/**
	 * Add variable
	 * eg. 	$tpl->addVar('name', 'value');
	 *
	 * @param mixed $variable_name Name of template variable or associative array name/value
	 * @param mixed $value value assigned to this variable. Not set if variable_name is an associative array
	 */
	public function addVar($variable, $value = null) {
	
		if( is_array( $variable ) ) {
		
			$this->var += $variable;
			
		} else {
		
			$this->var[ $variable ] = $value;
		
		}
		
	}

	/**
	 * Display the template
	 * eg. 	$html = $tpl->display( 'test', '', '', TRUE ); // return template in string
	 * or 	$tpl->display( 'test' ); // echo the template
	 *
	 * @param string $tplName  template filename
	 * @param string $module  template module dir
	 * @param string $subModule  template submodule dir
	 * @param boolean $return_string  true=return a string, false=echo the template
	 * @throws Exception    If errors in compiled file
	 * @return string
	 */	
	public function display($tplName, $module = false, $subModule = false, $returnTemplate = false) {

		$this->checkTemplate($tplName, $module, $subModule);
			
		try {
		
			ob_start();
			extract($this->var);

			include $this->tpl['compileFile'];
			$content = ob_get_clean();
			
			if(!$returnTemplate)
				echo $content; 
			else
				return $content;
			
			unset($this->tpl); // free memory
			unset($this->var);
		
		} catch(Exception $e) {

			ob_end_clean();
			
			throw new ErrorException($e->getMessage(), $e->getCode(), 0, $this->tplDir . DS . $tplName. ( $module ?  DS . $module : '' ) . ( $subModule ?  DS . $subModule : '' ) . '.' . $this->defaultExtension, $e->getLine());
			
		}
	}

	/**
	 * check if has to compile the template
	 *
	 * @param string $tplName  template filename
	 * @param string $module  template module dir
	 * @param string $subModule  template submodule dir
	 * @throws Exception    If file not exists
	 * @compiling template if it was changed 
	 */
	protected function checkTemplate($tplName, $module = false, $subModule = false) {

		
		if(!is_dir($this->cacheDir)) 
			mkdir($this->cacheDir, 0775, true);

		if( $module && !is_dir($this->cacheDir . DS . $module)) 
			mkdir($this->cacheDir . DS . $module, 0775, true);

		if( $module && $subModule && !is_dir($this->cacheDir . DS . $module . DS . $subModule)) 
			mkdir($this->cacheDir . DS . $module . DS . $subModule, 0775, true);				

		$this->tpl['file'] 			= $this->tplDir . ( $module ?  DS . $module : '' ) . ( $subModule ?  DS . $subModule : '' ) . DS . $tplName . '.' . $this->defaultExtension;
		$this->tpl['compileFile'] 	= $this->cacheDir . ( $module ?  DS . $module : '' ) . ( $subModule ?  DS . $subModule : '' ) . DS . $tplName . '.' . md5 ( $tplName . $this->defaultExtension ) . '.' . $this->cacheSuffix . '.php';			
		
		if( !file_exists( $this->tpl['file'] ) ) {
			
			throw new Exception("File " . $this->tpl['file'] . " not founded");
		
		}
				
		if( !file_exists($this->tpl['compileFile']) || ( filemtime($this->tpl['compileFile']) < filemtime($this->tpl['file']) ) || ( time() - filemtime($this->tpl['compileFile']) > self::$cacheExpireTime )  ) {		

			$this->compileFile($tplName);
		
		}

	}

	/**
	 * Compile and write the compiled template file
	 * @access protected
	 */
	protected function compileFile($tplName) {
	
		$this->tpl['source'] = $templateCode = file_get_contents( $this->tpl['file'] );
		
		if( !self::$phpEnabled )
			$templateCode = str_replace( array("<?","?>"), array("&lt;?","?&gt;"), $templateCode );		
		
		$templateCompiled = "<?php if(!class_exists('" . __CLASS__ . "')){exit;}?>" . $this->compileTemplate( $templateCode );
		
		/*$templateCompiled = preg_replace( array("~\?>~u", "~\t+~u", "~\?>\s{2,}~u", "~\s+$~"), array("?>\n", "", "?>\n", ""), $templateCompiled );*/
		$templateCompiled = preg_replace( array("~\t+~u"), array(""), $templateCompiled );

		
		file_put_contents($this->tpl['compileFile'], $templateCompiled);
		
	}

	/**
	 * Compile template
	 * @access protected
	 */	
	protected function compileTemplate($templateCode)
	{
	
		$tagRegexp = "/" . join( "|", $this->tagRegexp ) . "/";
		
		$templateCode = preg_split ( $tagRegexp, $templateCode, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY );

		
		$compileCode = $this->compileCode( $templateCode );
		
		return $compileCode;
		
	}

	/**
	 * Compile the code
	 * @access protected
	 */
	protected function compileCode( $parsedCode ) {

		$compiledCode = $open_if = $open_for = $open_foreach = false;

		foreach( $parsedCode as $html) {
			
			if( preg_match( '/\{include=\/?(?:([\w]+))\/?(?:([\w]+)*)\/?(?:([\w]+)*)\}/' , $html, $code ) ) {
				
				$count = count($code);
				
				switch($count) {
					
					case 2:					
						$condition = '"' . $code[ 1 ] . '"';
						break;
					
					case 3:
						$condition = '"' . $code[ 2 ] . '" , "' . $code[ 1 ] . '"';

						break;
					
					case 4:
						$condition = '"' . $code[ 3 ] . '" , "' . $code[ 1] . '" , "' . $code[ 2 ] . '"';

						break;
				
				}

				$compiledCode .= '<?php
									$template = new ' . __CLASS__ . ';
									$template->addVar($this->var);
									$template->display(' . $condition . ');
									?>';
									
			} elseif( strpos( $html, '{/ignore}' ) !== FALSE || strpos( $html, '*}' ) !== FALSE ) {
			
				$compiledCode .= '*/ ?>';
				
				$open_ignore--;				
			
			} elseif( strpos( $html, '{ignore}' ) !== FALSE || strpos( $html, '{*' ) !== FALSE ) {
	 		
				$compiledCode .= '<?php /*';
				
				$open_ignore++;
			
			} elseif( preg_match( '/\{while="([^"]*)"\}/', $html, $code ) ) {
				
				$open_if++;
									
				$condition = $this->varFormat($code[ 1 ]);
				

				$compiledCode .=   "<?php while( $condition ){ ?>";
			
			} elseif( preg_match( '/\{if="([^"]*)"\}/', $html, $code ) ) {
				
				$open_if++;
									
				$condition = $this->varFormat($code[ 1 ]);
				
				$compiledCode .=   "<?php if( $condition ){ ?>";
	
			} elseif( preg_match( '/\{elseif="([^"]*)"\}/', $html, $code ) ) {
			
				$condition = $this->varFormat($code[ 1 ]);

				$compiledCode .=   "<?php }elseif( $condition ){ ?>";				
			
			
			} elseif( strpos( $html, '{else}' ) !== FALSE ) {

				$compiledCode .=   '<?php }else{ ?>';

			} elseif( strpos( $html, '{/if}' ) !== FALSE ) {

				$open_if--;

				$compiledCode .=   '<?php } ?>';
			
			} elseif( strpos( $html, '{/elseif}' ) !== FALSE ) {

				$open_if--;

				$compiledCode .=   '<?php } ?>';
			
			} elseif( strpos( $html, '{/else}' ) !== FALSE ) {

				$open_if--;

				$compiledCode .=   '<?php } ?>';
			
			} elseif( preg_match( '/\{for="([^"]*?)\s*;\s*([^"]*?)\s*;\s*([^"]*?)"\}/', $html, $code ) ) {
				
				$open_for++;
				
				$expr1 = $this->varFormat($code[ 1 ]);
				$expr2 = $this->varFormat($code[ 2 ]);
				$expr3 = $this->varFormat($code[ 3 ]);
				
				$condition = $expr1 . ';' . $expr2 . ';' . $expr3;

				$compiledCode .=   "<?php for( $condition ){ ?>";
	
			} elseif( strpos( $html, '{/while}' ) !== FALSE ) {
			
				$open_for--;

				$compiledCode .=   '<?php } ?>';				

			} elseif( strpos( $html, '{/for}' ) !== FALSE ) {
			
				$open_for--;

				$compiledCode .=   '<?php } ?>';				

			} elseif( preg_match( '/\{foreach="([^"\s]+)\s+as\s+(?:([^"\s]+)\s*=>|)\s*([^"\s]+)"\}/', $html, $code ) ) {
				
				$open_foreach++;
				
				$array 	= $this->varFormat($code[ 1 ]);
				$key 	= $this->varFormat($code[ 2 ]);
				$value 	= $this->varFormat($code[ 3 ]);
				
				if( $key == '') {
				
					$condition = "$array as $value";
				
				} else {
				
					$condition = "$array as $key=>$value";
				
				}
				
				$compiledCode .= "<?php foreach( $condition ){ ?>";
				
			
			} elseif( strpos( $html, '{/foreach}' ) !== FALSE ) {

				$open_foreach--;
				
				$compiledCode .=   '<?php } ?>';	
				
			} else {
				
				$compiledCode .= $this->varReplace($html);
			}

		}


		if( $open_if > 0 ) {
		
			throw new Exception("Syntax error: no closed {IF} tag");
		
		}
		
		if( $open_foreach > 0 ) {
		
			throw new Exception("Syntax error: no closed {FOREACH} tag");
		
		}
		
		if( $open_for > 0 ) {
		
			throw new Exception("Syntax error: no closed {FOR} tag");
		
		}	
	
	
		return $compiledCode;
	
	}

	/**
	 * var replacing
	 * @param mixed $html template
	 * @param mixed $tag_left_delimiter
	 * @param mixed $tag_right_delimiter
	 * @param boolean $echo  true=add var with echo to compiled code, false=add var to compiled code
	 * @access protected
	 */	
	protected function varReplace($html) {
	
		preg_match_all( '~(?:<style[^>]*>[^<>]+</style>|<script[^>]*>[^<>]+</script>)~is', $html, $escapes, PREG_OFFSET_CAPTURE );
		
		if( preg_match_all( '~\{([^{}\n\r]+)\}~', $html, $matches, PREG_OFFSET_CAPTURE ) ){
			
			foreach($matches[1] As $key => $tags) {
			
				foreach($escapes[0] As $escape) {
				
					if( $tags[1] > $escape[1] && $tags[1] < ( $escape[1] + mb_strlen($escape[0]) ) ) {
						continue(2);
					}
				}
				
				// echo or operation
				$echo = !preg_match( '~\$[^=!<>]+=[^=]~', $tags[0]);
				
				$html = str_replace( '{' . $matches[1][$key][0] . '}' , '<? ' . ($echo ? 'echo ' : '') . $this->varFormat($tags[0]) . ';?>', $html);
				
			}
			
		}
		
		return $html;
	}
	
	
	protected function varFormat($expr) {
		
		$matches = array();
		$replaces = array();
		
		if(preg_match_all('~(\$\w+)((?:\.\w+)+)~', $expr, $matches)) {
			
			foreach($matches[2] As $key => $var) {
				
				$replaces[] = array(strlen($key), $matches[1][$key] . $var, $matches[1][$key] . '["' . str_replace('.', '"]["', trim($var, '.')) . '"]');
				
			}
		}
		
		usort($replaces, function ($a, $b) 
		{
			return $a[0] < $b[0];
		});
		
		foreach($replaces As $key => $var) {
			
			$expr = str_replace($var[1], $var[2], $expr);
			
		}
		
		return $expr;
		
	}
	
}