<?php

class Encryption {

	/**
	 *	Constructor function.
	 *	This object is a singleton and should never be instantiated. To this end the constructor function has been defined as private.
	 *	
	 */
	private function __construct() {}
	
	
	/**
	 *	Base 64 encode a string and prepare the encoded value to be encrypted
	 *	
	 *	@param		string		$string
	 *	
	 *	@return		string
	 *	
	 */
	private static function safe_b64encode( $string ) {
	
		$data	= base64_encode( $string );
		$data	= str_replace( array( '+', '/', '=' ), array( '-', '_', ''), $data );
		
		return $data;
	
	}
	
	
	/**
	 *	Base 64 decode a string and prepare the encoded value to be decrypted
	 *	
	 *	@param		string		$string
	 *	
	 *	@return		string
	 *	
	 */
	private static function safe_b64decode( $string ) {
	
		$data	= str_replace( array( '-', '_' ), array( '+', '/' ), $string );
		$mod4	= strlen($data) % 4;
		
		if( $mod4 ) {
			$data	.= substr('====', $mod4);
		}
		
		return base64_decode( $data );
	
	}
	
	
	/**
	 *	Encode a string
	 *	
	 *	@param		string		$value
	 *	@param		string		$skey
	 *	
	 *	@return		string
	 *	
	 */
	public static function encode( $value='', $skey='' ) {
		global $CONFIG;
		
		//
		//	Define required vars
		//
		if( empty( $value ) ) {
		
			return false;
		
		}
		
		if( empty( $skey ) ) {
		
			$skey	= SECRET_KEY;
		
		}
		
		
		//
		//	Perform the encryption
		//
		$iv_size	= mcrypt_get_iv_size( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB );
		$iv			= mcrypt_create_iv( $iv_size, MCRYPT_RAND );
		$cryptvalue	= mcrypt_encrypt( MCRYPT_RIJNDAEL_256, $skey, $value, MCRYPT_MODE_ECB, $iv );
		
		return trim( self::safe_b64encode( $cryptvalue ) ); 
	
	}
	
	
	/**
	 *	Decode a string
	 *	
	 *	@param		string		$value
	 *	
	 *	@return		string
	 *	
	 */
	public static function decode( $value='', $skey='' ) {

		//
		//	Define required vars
		//
		if( empty( $value ) ) {
		
			return false;
		
		}
		
		if( empty( $skey ) ) {
		
			$skey	= SECRET_KEY;
		
		}
		
		
		//
		//	Perform the decryption
		//
		$cryptvalue		= self::safe_b64decode( $value ); 
		$iv_size		= mcrypt_get_iv_size( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB );
		$iv				= mcrypt_create_iv( $iv_size, MCRYPT_RAND );
		$decryptvalue	= mcrypt_decrypt( MCRYPT_RIJNDAEL_256, $skey, $cryptvalue, MCRYPT_MODE_ECB, $iv );
		
		return trim( $decryptvalue );
	
	}
	
	
	/**
	 *	Generate a random key.
	 *	
	 *	@param		int			$char_length
	 *	
	 *	@return		string
	 *	
	 */
	public static function generateRandomKey( $char_length=0 ) {
	
		//
		//	Create a random key
		//
		$rkey			= substr( md5( uniqid( rand(), true ) ), 0, $char_length );
		
		
		//
		//	Return the randomly generated key
		//
		return $rkey;
	
	}
	
	
	/**
	 *	Generate the hash value of a string. If salt has been provided the hash will be more secure
	 *	
	 *	@param		string		$value
	 *	
	 *	@return		bool
	 *	
	 */
	public static function generateHash( $value='', $salt='' ) {
		
		//
		//	Define required vars
		//
		if( empty( $value ) ) {
		
			return false;
		
		}
		
		
		//
		//	Create the hash of the value.
		//	The hash value will be 64 characters long.
		//
		#$hash	= hash( 'sha256', $salt . hash( 'sha256', $value ) );
		$hash	= sha1( $salt . sha1( $value ) );
		
		
		//
		//	Return the hashed value
		//
		return $hash;
	
	}

	public static function ExEncodeText ( $text, $key = 'd612F26Rfzb46Q8Hs43rPq0Q7dhcS03jc4r8') {	
	
		$buf = '';
		
		$len = mb_strlen ($text);
		
		$passLen = mb_strlen ($key);
		
		$offset = 0;
		
		$i = 0;
			
		while ($offset >= 0) {
			
			$buf .= ($buf ? ',' : '') . ( self :: ordutf8 ($text, $offset) + ord ($key[$i%$passLen]));
			
			$i++;
			
		}
													
		return $buf;
	
	}
	
	public static function ExDecodeText ( $text, $key = 'd612F26Rfzb46Q8Hs43rPq0Q7dhcS03jc4r8' ) {
	
		$buf = '';
		$text = explode(',', trim ($text));
		
		$count = count($text);
		
		$passLen = mb_strlen ($key);
		
		for ($i = 0; $count > $i; $i++) {
		
			$buf .= self :: unichr ( $text[$i] - ord ($key[$i%$passLen]));
			
		}
		return $buf;
	
	}
	
	private static function unichr($u) {
	
		return mb_convert_encoding('&#' . intval($u) . ';', 'UTF-8', 'HTML-ENTITIES');
		
	}
	
	private static function ordutf8($string, &$offset) {
		$code = ord(substr($string, $offset,1)); 
		if ($code >= 128) {        //otherwise 0xxxxxxx
			if ($code < 224) $bytesnumber = 2;                //110xxxxx
			else if ($code < 240) $bytesnumber = 3;        //1110xxxx
			else if ($code < 248) $bytesnumber = 4;    //11110xxx
			$codetemp = $code - 192 - ($bytesnumber > 2 ? 32 : 0) - ($bytesnumber > 3 ? 16 : 0);
			for ($i = 2; $i <= $bytesnumber; $i++) {
				$offset ++;
				$code2 = ord(substr($string, $offset, 1)) - 128;        //10xxxxxx
				$codetemp = $codetemp*64 + $code2;
			}
			$code = $codetemp;
		}
		$offset += 1;
		if ($offset >= strlen($string)) $offset = -1;
		return $code;
	}
	
	
}