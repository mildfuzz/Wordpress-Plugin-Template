<?php 
global $mf_plugin;
$mf_plugin->fetch_post('hello');

function hello(){
	fb::log($_POST,'post');
}
?>
<h3>Hello World</h3>
<form method="post" action="">
	<input type="hidden" name="cock" value="balls" />
	<input type="submit" />
</form>