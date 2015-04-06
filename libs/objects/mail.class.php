<?php

class Mail {

	/**
	 * Send mail
	 * eg. 	$mail->send( 'Hello World', 'Message', array("by.attention@gmail.com", "ilirien1@mail.ru") );
	 *
	 * @param string $subject Name of template variable or associative array name/value
	 * @param string $message Name of template variable or associative array name/value
	 * @param array $recipients Name of template variable or associative array name/value
	 * @param bool $isHtml send mail with text/plain or text/html header
	 * @param string $from_mail sender mail
	 * @param string $from_who sender name
	 */
	public static function send($subject, $message, $recipients = array(), $isHtml = true, $from_mail = DEFAULT_MAIL, $from_who = DEFAULT_MAIL_FROM)
	{

		$type 	= $isHtml ? 'html' : 'plain';
		$header = "From: \"" . $from_who . "\" <" . $from_mail . ">\n";
		
		$header .= "Content-type: text/" . $type . "; charset=\"utf-8\"";
		
		foreach($recipients as $to) {

			$res = mail($to, $subject, $message, $header);
			
		}
		
		return $res;
		
	}
	
}