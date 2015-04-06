<?php

class Date {

	public function getDate($date, $format) {
	
		$date = strtotime($date);		
		$day = date("d", $date);
		
		$nowDay = date("d");
		
		if( $day == $nowDay ) {
		
			$d = 'Today';
		
		} elseif ( ($day + 1) == $nowDay ) {
		
			$d = 'Yesterday';
		
		} else {
		
			$d = date($format, $date);
		
		}
		
		return $d;

	}

}