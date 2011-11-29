<?php
class mf {
	/**
	 * Generic function to show a message to the user using WP's
	 * standard CSS classes to make use of the already-defined
	 * message colour scheme.
	 *
	 * @param $message The message you want to tell the user.
	 * @param $errormsg If true, the message is an error, so use
	 * the red message style. If false, the message is a status
	  * message, so use the yellow information message style.
	 */
	static function wpLog ($message, $errormsg = false)
	{
		if ($errormsg) {
			echo '<div id="message" class="error">';
		}
		else {
			echo '<div id="message" class="updated fade">';
		}

		echo "<p><strong>$message</strong></p></div>";
	}

	/**
	 * Just show our message (with possible checking if we only want
	 * to show message to certain users.
	 */
	function buildUrlQuery($query, $get = true){
		//merge querys
		if($get) $query = array_merge($_GET, $query);
		
		if(!is_array($query)) die ("urlQuery requires an array as its argument.");

		$url_ext = "?";
		foreach($query as $k => $v){
			$url_ext .=$k."=".$v."&amp;";
		}
		$url_ext = substr($url_ext, 0, -5);//chop last ampersand off


		return $url_ext;

	}
	function removeURLQuery($query){
		if(is_array($query)){
			foreach ($query as $v){
				removeURLQuery($v);
			}
		}
		$get = $_GET;
		if(array_key_exists($query, $get)) {
			unset($get[$query]);
		} 
		return $get;
	}
	function thisPage() {
	 	$pageURL = 'http';
	 	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	 	$pageURL .= "://";
	 	if ($_SERVER["SERVER_PORT"] != "80") {
	  		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	 	} else {
	  		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 	}
	 	return $pageURL;
	}
	static function urlQuery($query){
		$curl = explode("?",$_SERVER['REQUEST_URI']);
		$query = self::buildUrlQuery($query);
		return $curl[0].$query;
	}
	
	static function removeQueryElements($query_elements = array()){
		$get = $_GET;
		foreach($get as $k=>$v){
			if(array_key_exists($k, array_flip($query_elements))) unset($get[$k]);
		}
		
		$new_query = self::buildUrlQuery($get, false);
		
		$curl = explode("?",$_SERVER['REQUEST_URI']);
		return $curl[0].$new_query;
		
	}
	
	static function clean($str = '', $html = false) {
		//is String Empty?
		if (empty($str)) return false;

		//is String an array? If so, run clean with each item.
		if (is_array($str)) {
			foreach($str as $key => $value) $str[$key] = self::clean($value, $html);
		} else {
			// get magic quotes
			if (get_magic_quotes_gpc()) $str = stripslashes($str);
			//is HTML an Array?
			if (is_array($html)) $str = strip_tags($str, implode('', $html));
			//is html a valid html tag?
			elseif (preg_match('|&lt;([a-z]+)&gt;|i', $html)) $str = strip_tags($str, $html);
			//is html false?
			elseif ($html !== true) $str = strip_tags($str);
			$str = trim($str);
		}
		return $str;
	}
}

?>