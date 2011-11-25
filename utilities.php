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
	function curPageURL() {
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
}

?>