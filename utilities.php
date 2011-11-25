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
	static function urlQuery($query){
		if(!is_array($query)) die ("urlQuery requires an array as its argument.");

		$url_ext = "?";
		foreach($query as $k => $v){
			$url_ext .=$k."=".$v."&amp;";
		}
		$url_ext = substr($url_ext, 0, -5);//chop last ampersand off


		return $url_ext;

	}
}

?>